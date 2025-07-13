<?php

namespace App\Console\Commands;

use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
use Illuminate\Console\Command;
use App\Models\Events\Order;
use Carbon\Carbon;
use DB;

class CancelUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically cancel unpaid orders after $cutoffTime (15) minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoffTime = Carbon::now()->subMinutes(15);
        
        Order::with('tickets')
            ->where('payment_status', 'pending')
            ->where('last_interaction_time', '<=', $cutoffTime)
            ->chunkById(100, function ($orders) {
                foreach ($orders as $order) {
                    $this->cancelOrder($order);
                }
            });
        
        $this->info('Auto-cancellation completed.');
    }

    protected function cancelOrder(Order $order)
    {
        try {
            DB::beginTransaction();

            foreach ($order->tickets as $ticket) {
                $ticket->update([
                    'payment_status' => 'cancelled'
                ]);

                if ($ticket->is_seat) {
                    EventSeat::where('id', $ticket->seat_id)->update(['status' => 'available']);
                } else {
                    EventStandingTicket::where('id', $ticket->standing_id)->decrement('reserved');
                }

                $ticket->update([
                    'order_id' => null
                ]);
            }

            $order->update([
                'payment_status' => 'cancelled',
            ]);

            DB::commit();

            // Mozna to dodac email nwm pozniej to zrobie, niezbyt wazne chyba

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Failed to cancel order #{$order->id}: " . $e->getMessage());
            logger()->error("Auto-cancel failed for order #{$order->id}", ['error' => $e]);
        }
    }
}
