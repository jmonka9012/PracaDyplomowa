<?php

namespace App\Http\Controllers\Events;

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

class TicketSaleController extends Controller
{
    public function store(TicketSaleRequest $request): SymfonyResponse
    {
            
        $validatedData = $request->validated();

        return DB::transaction(function () use ($validatedData){
            $tickets = [];
            $userId = Auth::id();
            $isGuest = Auth::guest();
            $totalPrice = 0;
            $ticketDetails = [];

            if (isset($validatedData['seats'])){
                foreach($validatedData['seats'] as $seat) {
                    $seatPrice = DB::table('event_seats')
                        ->where('id', $seat['id'])
                        ->value('price');
                    
                    $tickets[] = Ticket::create([
                        'event_id' => $validatedData['event_id'],
                        'user_id' => $userId,
                        'is_seat' => true,
                        'seat_id' => $seat['id'],
                        'standing_id' => null,
                        'insured' => false,
                        'is_guest' => $isGuest,
                    ]);

                    $totalPrice += $seatPrice;
                    $ticketDetails[] = "Seat Ticket: {$seat['id']} - PLN" . number_format($seatPrice, 2);

                    DB::table('event_seats')
                        ->where('id', $seat['id'])
                        ->update(['status' => 'reserved']);
                }
            }

            if (!empty($validatedData['standing_tickets'])) {
                foreach($validatedData['standing_tickets'] as $standingTicket) {
                    if (!isset($standingTicket['amount']) || $standingTicket['amount'] < 1) {
                        continue;
                    }
            
                    $standingPrice = DB::table('event_standing_tickets')
                        ->where('id', $standingTicket['id'])
                        ->value('price');

                    DB::table('event_standing_tickets')
                        ->where('id', $standingTicket['id'])
                        ->increment('reserved', $standingTicket['amount']);

                    for ($i = 0; $i < $standingTicket['amount']; $i++) {
                        $tickets[] = Ticket::create([
                            'event_id' => $validatedData['event_id'],
                            'user_id' => $userId,
                            'is_seat' => false,
                            'seat_id' => null,
                            'standing_id' => $standingTicket['id'],
                            'insured' => $validatedData['insured'] ?? false,
                            'is_guest' => $isGuest,
                        ]);
                    }
            
                    $totalPrice += $standingPrice * $standingTicket['amount'];
                    $ticketDetails[] = "Standing Ticket: {$standingTicket['id']} x {$standingTicket['amount']} - PLN" . number_format($standingPrice, 2);
                }

                    Stripe::setApiKey(config('services.stripe.secret'));

                    \Log::debug('Attempting Stripe checkout with amount: ' . $totalPrice);

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
                                'user_id' => $userId ?? 'guest',
                                'event_id' => $validatedData['event_id'],
                                'ticket_ids' => json_encode(array_column($tickets, 'id')),
                            ],
                        ]);

                        session([
                            'current_stripe_session' => $session->id,
                            'reserved_ticket_ids' => collect($tickets)->pluck('id')->toArray(),
                        ]);

                        // return redirect()   ->away($session->url)
                        //                     ->header('Access-Control-Allow-Origin', 'https://checkout.stripe.com')
                        //                     ->header('Access-Control-Allow-Credentials', 'true');
                        return Inertia::location($session->url);
                    } catch (\Exception $e) {
                                    DB::rollBack();
                                    return back()->with('error', 'Payment processing error: ' . $e->getMessage());
                    }
                } 
        });
    }

    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        
        try {
            $session = Session::retrieve($request->get('session_id'));

            if (session('current_stripe_session') !== $session->id) {
                throw new \Exception('Invalid session ID');
            }

            $ticketIds = json_decode($session->metadata->ticket_ids);
            $tickets = Ticket::whereIn('id', $ticketIds)->get();

            $standingUpdates = [];

            foreach ($tickets as $ticket) {
                if (!$ticket->is_seat && $ticket->standing_id) {
                    if (!isset($standingUpdates[$ticket->standing_id])) {
                        $standingUpdates[$ticket->standing_id] = 0;
                    }
                    $standingUpdates[$ticket->standing_id]++;
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

            Ticket::whereIn('id', $ticketIds)->update(['payment_status' => 'paid']);

            session()->forget('current_stripe_session');

                // return response()->json([
                //     'redirect_url' => $session->url
                // ], 200, [
                //     'Access-Control-Allow-Origin' => '*',
                //     'Access-Control-Allow-Methods' => 'POST, OPTIONS',
                //     'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With'
                // ]);
                //route do podsumowania tu trzeba zrobić
                return redirect()->route('home');

        }catch (\Exception $e) {
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

                $ticketIds = json_decode($session->metadata->ticket_ids);
                $tickets = Ticket::whereIn('id', $ticketIds)->get();

                $standingUpdates = [];
                foreach ($tickets as $ticket) {
                    if (!$ticket->is_seat && $ticket->standing_id) {
                        if (!isset($standingUpdates[$ticket->standing_id])) {
                            $standingUpdates[$ticket->standing_id] = 0;
                        }
                        $standingUpdates[$ticket->standing_id]++;
                    }
                }

                foreach ($standingUpdates as $standingId => $count) {
                    DB::table('event_standing_tickets')
                        ->where('id', $standingId)
                        ->decrement('reserved', $count);
                }

                Ticket::whereIn('id', $ticketIds)->delete();
                
            } catch (\Exception $e) {
            \Log::error('!!!IMPORTANT!!! Failed to clean up after canceled payment: ' . $e->getMessage());
            }

            session()->forget('current_stripe_session');
        }
        return redirect()->route('home');
    }

    public function orderDataForm()
    {
        return Inertia::render('Events/EventForm');
    }

        public function orderDataPost()
    {
        return Inertia::render('Events/EventForm');
    }
}
