<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Events\Event;
use App\Models\Events\Order;
use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketArchived;
use Faker\Factory as Faker;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        EventSeeder::class;

        User::factory()->count(50)->create();

        $users = User::all();
        $events = Event::with(['seats', 'standingTickets'])->get();

        for ($i = 0; $i < 100; $i++){
            $event = $events->random();
            $isGuest = $faker->boolean(30);
            
            $userId = null;
            if (!$isGuest) {
                $userId = $users->random()->id;
            }

            $orderData = [
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'event_id' => $event->id,
                'user_id' => $userId,
                'total_price' => 0,
                'phone' => $faker->phoneNumber,
                'email' => $isGuest ? $faker->safeEmail : $faker->randomElement($users->pluck('email')->toArray()),
                'country' => $faker->countryCode,
                'city' => $faker->city,
                'street' => $faker->streetName,
                'house_number' => $faker->buildingNumber,
                'zip_code' => $faker->postcode,
                'payment_status' => $faker->randomElement(['paid']),
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
            ];

            $order = Order::create($orderData);

            $totalPrice = 0;
            
            $ticketCount = $faker->numberBetween(1, 5);

            $availableSeats = $event->seats()->where('status', 'available')->get();
            $availableStanding = $event->standingTickets()->whereRaw(('capacity > sold'))->get();

            $ticketsCreated = 0;

            while ($ticketsCreated < $ticketCount && (!$availableSeats->isEmpty() || !$availableStanding->isEmpty())){
                $useSeat = ($availableSeats->isNotEmpty() && $faker->boolean(60)) || $availableStanding->isEmpty();
                
                if ($useSeat && $availableSeats->isNotEmpty()) {
                    $seat = $availableSeats->random();

                    $ticket = Ticket::create([
                        'is_guest' => $isGuest,
                        'user_id' => $userId,
                        'order_id' => $order->id,
                        'event_id' => $event->id,
                        'seat_id' => $seat->id,
                        'price' => $seat->price,
                        'payment_status' => 'paid',
                        'is_seat' => true,
                    ]);

                    $seat->update(['status' => 'sold']);
                    $availableSeats = $availableSeats->except([$seat->id]);
                    $totalPrice += $seat->price;

                    $ticketsCreated++;
                } elseif ($availableStanding->isNotEmpty()) {
                    $standing = $availableStanding->random();
                    
                    $ticket = Ticket::create([
                        'is_guest' => $isGuest,
                        'user_id' => $userId,
                        'order_id' => $order->id,
                        'event_id' => $event->id,
                        'standing_id' => $standing->id,
                        'price' => $standing->price,
                        'payment_status' => 'paid',
                        'is_seat' => false,
                    ]);
                    
                    $standing->increment('sold');
                    if ($standing->sold >= $standing->capacity) {
                        $availableStanding = $availableStanding->except([$standing->id]);
                    }
                    $totalPrice += $standing->price;
                    $ticketsCreated++;
                }
                $order->update(['total_price' => $totalPrice]);

                if ($ticketsCreated === 0) {
                    $order->delete();
                    $i--;
                }
            }
        }
    }
}