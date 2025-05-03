<?php

namespace App\Http\Controllers\Events;

use App\Http\Requests\TicketSaleRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\Tickets\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class TicketSaleController extends Controller
{
    public function store(TicketSaleRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        return DB::transaction(function () use ($validatedData){
            $tickets = [];
            $userId = Auth::id();
            $isGuest = Auth::guest();
            $totalPrice = 0;

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

                    DB::table('event_seats')
                        ->where('id', $seat['id'])
                        ->update(['status' => 'sold']);
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
            
                    $totalPrice += $standingPrice;

                    DB::table('event_standing_tickets')
                        ->where('id', $standingTicket['id'])
                        ->increment('sold', $standingTicket['amount']);
                }
            }

            return redirect()->route('home');
        });
    } 
    //todo @JacekMonka @Yen1312 bramka płatności
    //todo @Yen1312 faktury i        
}
