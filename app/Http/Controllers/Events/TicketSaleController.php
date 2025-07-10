<?php

namespace App\Http\Controllers\Events;

use App\Http\Requests\OrderDetailsRequest;
use App\Http\Requests\TicketSaleRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Tickets\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use App\Models\Events\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;

class TicketSaleController extends Controller
{
    public function payment(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return redirect()->route('home')->with('error', 'Zamówienie zostało już opłacone.');
        }
        
        $totalPrice = 0;
        $ticketDetails = [];

        foreach ($order->tickets as $ticket) {
            $price = $ticket->price;
            $totalPrice += $price;

            $label = $ticket->is_seat
                ? "Seat Ticket: {$ticket->seat_id}"
                : "Standing Ticket: {$ticket->standing_id}";
            $ticketDetails[] = "{$label} - PLN " . number_format($price, 2);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'pln',
                        'product_data' => [
                            'name' => 'Bilety',
                            'description' => implode("\n", $ticketDetails),
                        ],
                        'unit_amount' => $totalPrice * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('tickets.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('tickets.payment.cancel'),
                'metadata' => [
                    'user_id' => $order->user_id ?? 'guest',
                    'order_number' => $order->order_number,
                ],
            ]);

            session([
                'current_stripe_session' => $session->id,
                'current_order_number' => $order->order_number,
            ]);

            return Inertia::location($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Błąd płatności: ' . $e->getMessage());
    }
    }

    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($request->get('session_id'));

            if (session('current_stripe_session') !== $session->id) {
                throw new \Exception('Invalid session ID');
            }

            $orderNumber = $session->metadata->order_number;
            $order = Order::with('tickets')->where('order_number', $orderNumber)->firstOrFail();

            if ($order->payment_status === 'paid') {
                return redirect()->route('home')->with('error', 'Zamówienie zostało już opłacone.');
            }

            $tickets = $order->tickets;

            $standingUpdates = [];
            foreach ($tickets as $ticket) {
                if (!$ticket->is_seat && $ticket->standing_id) {
                    $standingUpdates[$ticket->standing_id] = ($standingUpdates[$ticket->standing_id] ?? 0) + 1;
                }
            }

            foreach ($standingUpdates as $standingId => $count) {
                DB::table('event_standing_tickets')
                    ->where('id', $standingId)
                    ->decrement('reserved', $count);

                DB::table('event_standing_tickets')
                    ->where('id', $standingId)
                    ->increment('sold', $count);
            }

            Ticket::whereIn('id', $tickets->pluck('id'))->update(['payment_status' => 'paid']);

            $order->update(['payment_status' => 'paid']);

            session()->forget('current_stripe_session');
            session()->forget('current_order_number');

            return redirect()->route('home')->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            \Log::error('Payment success handling error: ' . $e->getMessage());
            return redirect()->route('tickets.payment.cancel');
        }
    }


    public function paymentCancel()
    {
        $sessionId = session('current_stripe_session');

        if ($sessionId) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $session = Session::retrieve($sessionId);

                $orderNumber = $session->metadata->order_number;
                $order = Order::with('tickets')->where('order_number', $orderNumber)->first();

                if ($order) {
                    $tickets = $order->tickets;

                    $standingUpdates = [];
                    foreach ($tickets as $ticket) {
                        if (!$ticket->is_seat && $ticket->standing_id) {
                            $standingUpdates[$ticket->standing_id] = ($standingUpdates[$ticket->standing_id] ?? 0) + 1;
                        }
                    }

                    foreach ($standingUpdates as $standingId => $count) {
                        DB::table('event_standing_tickets')
                            ->where('id', $standingId)
                            ->decrement('reserved', $count);
                    }

                    Ticket::whereIn('id', $tickets->pluck('id'))->delete();
                    $order->delete();
                }
            } catch (\Exception $e) {
                \Log::error('!!!IMPORTANT!!! Failed to clean up after canceled payment: ' . $e->getMessage());
            }

            session()->forget('current_stripe_session');
            session()->forget('current_order_number');
        }

        return redirect()->route('home')->with('error', 'Anulowano płatność.');
    }

    public function orderDataForm(TicketSaleRequest $request)
    {
        return DB::transaction(function () use ($request) {

            $userId = Auth::id();
            $isGuest = Auth::guest();

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'total_price' => 0,
                'payment_status' => 'pending',
                'event_id' => $request->event_id,
                'user_id' => $userId
            ]);

            $totalPrice = $this->processSeats($request, $order);
            $totalPrice += $this->processStandingTickets($request, $order);

            $order->update(['total_price' => $totalPrice]);

            return redirect()->route('event-ticket.buy.form.details', $order);
        });
    }

    private function processSeats(TicketSaleRequest $request, Order $order): float
    {
        $totalPrice = 0;
        $userId = Auth::id();
        $isGuest = Auth::guest();

        if (isset($request->validated()['seats'])) {
            foreach ($request->validated()['seats'] as $seat) {
                $seatPrice = DB::table('event_seats')
                    ->where('id', $seat['id'])
                    ->value('price');

                Ticket::create([
                    'event_id' => $request->event_id,
                    'order_id' => $order->id,
                    'user_id' => $userId,
                    'is_seat' => true,
                    'seat_id' => $seat['id'],
                    'standing_id' => null,
                    'insured' => false,
                    'is_guest' => $isGuest,
                    'status' => 'reserved',
                    'price' => $seatPrice
                ]);

                $totalPrice += $seatPrice;

                DB::table('event_seats')
                    ->where('id', $seat['id'])
                    ->update(['status' => 'reserved']);
            }
        }

        return $totalPrice;
    }

    private function processStandingTickets(TicketSaleRequest $request, Order $order): float
    {
        $totalPrice = 0;
        $userId = Auth::id();
        $isGuest = Auth::guest();

        if (!empty($request->validated()['standing_tickets'])) {
            foreach ($request->validated()['standing_tickets'] as $standingTicket) {
                if (!isset($standingTicket['amount']) || $standingTicket['amount'] < 1) {
                    continue;
                }

                $standingPrice = DB::table('event_standing_tickets')
                    ->where('id', $standingTicket['id'])
                    ->value('price');

                for ($i = 0; $i < $standingTicket['amount']; $i++) {
                    Ticket::create([
                        'event_id' => $request->event_id,
                        'order_id' => $order->id,
                        'user_id' => $userId,
                        'is_seat' => false,
                        'seat_id' => null,
                        'standing_id' => $standingTicket['id'],
                        'insured' => $request->insured ?? false,
                        'is_guest' => $isGuest,
                        'status' => 'pending',
                        'price' => $standingPrice
                    ]);
                }

                DB::table('event_standing_tickets')
                    ->where('id', $standingTicket['id'])
                    ->increment('reserved', $standingTicket['amount']);

                $totalPrice += $standingPrice * $standingTicket['amount'];
            }
        }

        return $totalPrice;
    }

    public function orderDetailsForm(Order $order)
    {
        $userData = [];

        if (Auth::check()) {
            $user = Auth::user();
            $userData = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'country' => $user->country,
                'city' => $user->city,
                'street' => $user->street,
                'house_number' => $user->house_number,
                'zip_code' => $user->zip_code,
                'phone' => $user->phone,
            ];
        }

        return Inertia::render('Events/EventForm', [
            'order' => $order->load('tickets'),
            'user_data' => $userData
        ]);
    }


    public function orderDetailsUpdate(OrderDetailsRequest $request, Order $order)
    {
        $validated = $request->validated();
        $order->update($validated);

        if ($request->make_account && $request->has('password')){
            $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'country' => $validated['country'],
            'city' => $validated['city'],
            'street' => $validated['street'],
            'house_number' => $validated['house_number'],
            'zip_code' => $validated['zip_code'],
            ]);

            $order->user_id = $user->id;
            $order->save();

            Mail::to($user->email)->send(new VerifyEmail($user));
            Auth::login($user);
        }elseif ($request->save_data && Auth::check()) {
            $user = Auth::user();
            $user->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'country' => $validated['country'],
                'city' => $validated['city'],
                'street' => $validated['street'],
                'house_number' => $validated['house_number'],
                'zip_code' => $validated['zip_code'],
            ]);
        }

        return $this->payment($order);
    }
}
