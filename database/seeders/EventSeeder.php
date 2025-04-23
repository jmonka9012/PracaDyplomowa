<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Events\Event;
use App\Models\Events\Genre;
use App\Models\Hall;
use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
use Faker\Factory as Faker;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $halls = Hall::with('sections')->get();

        if ($halls->isEmpty()) {
            $this->command->error('No halls found. Run migration and hall seeder first.');
            return;
        }

        $genreNames = Genre::pluck('genre_name')->all();

        for ($i = 0; $i < 100; $i++) {
            $hall = $halls->random();

            $eventDescription = "<p><img src='/storage/event_images/placeholder.jpg'></p><hr><div><p>{$faker->paragraphs(3, true)}</p></div>";

            $eventData = [
                'event_name' => $faker->catchPhrase,
                'event_additional_url' => $faker->url,
                'event_date' => $faker->dateTimeBetween('+1 week', '+2 years'),
                'event_start' => $faker->time('H:i:s'),
                'event_end' => $faker->time('H:i:s'),
                'contact_email' => $faker->unique()->safeEmail,
                'contact_email_additional' => $faker->unique()->safeEmail,
                'event_description' => $eventDescription,
                'event_description_additional' => $faker->sentence,
                'event_location' => $hall->id,
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => false,
            ];

            $event = Event::create($eventData);

            $randomGenres = $faker->randomElements($genreNames, rand(1, 5));
            $genreIds = Genre::whereIn('genre_name', $randomGenres)->pluck('id')->all();
            $event->genres()->attach($genreIds);

            foreach ($hall->sections as $section) {
                if ($section->section_type === 'seat') {
                    $price = $faker->randomFloat(2, 5, 200);
                    for ($row = 1; $row <= $section->row; $row++) {
                        for ($col = 1; $col <= $section->col; $col++) {
                            EventSeat::create([
                                'hall_section_id' => $section->id,
                                'event_id' => $event->id,
                                'seat_row' => $row,
                                'seat_number' => $col,
                                'price' => $price,
                                'status' => $faker->randomElement(['available', 'sold']),
                            ]);
                        }
                    }
                } else {
                    EventStandingTicket::create([
                        'hall_section_id' => $section->id,
                        'event_id' => $event->id,
                        'capacity' => $section->capacity,
                        'sold' => $faker->numberBetween(0, $section->capacity),
                        'price' => $faker->randomFloat(2, 5, 50),
                    ]);
                }
            }
        }
    }
}
