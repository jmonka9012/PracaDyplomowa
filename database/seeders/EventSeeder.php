<?php

namespace Database\Seeders;

use App\Models\OrganizerInformation;
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

        $organizers = OrganizerInformation::pluck('id')->all();

        if ($halls->isEmpty()) {
            $this->command->error('No halls found. Run migration and hall seeder first.');
            return;
        }

        $genreNames = Genre::pluck('genre_name')->all();

        for ($i = 0; $i < 100; $i++) {
            $hall = $halls->random();
            $randomOrganizer = $faker->randomElement($organizers);

            $placeholderImages = [
                '/storage/demo/images/example1.jpg',
                '/storage/demo/images/example2.jpg',
                '/storage/demo/images/example3.jpg',
                '/storage/demo/images/example4.jpg',
                '/storage/demo/images/example5.jpg',
            ];

            $randomImage = $faker->randomElement($placeholderImages);

            $paragraphCount = $faker->numberBetween(2, 5);
            $randomParagraphs = $faker->paragraphs($paragraphCount, true);

            $eventDescription = sprintf(
                "<p><img src='%s' alt='Event Image'></p><hr><div>%s</div>",
                $randomImage,

                implode('', array_map(fn($p) => "<p>{$p}</p>", explode("\n", $randomParagraphs)))
            );

            $eventData = [
            'event_name' => $faker->randomElement([
                'Warsztaty kreatywnego pisania',
                'Konferencja marketingowa',
                'Szkolenie z programowania',
                'Targi pracy IT',
                'Webinar o sztucznej inteligencji',
                'Spotkanie networkingowe',
                'Wystawa sztuki współczesnej',
                'Koncert muzyki klasycznej',
                'Festiwalu filmowego',
                'Targi książki',
                'Koncert muzyki metalowej',
                'Koncert muzyki pop',
                'Koncert muzyki rock',
                'Koncert muzyki punk',
            ]),
            'event_date' => $faker->dateTimeBetween('+1 week', '+2 years'),
            'event_start' => $faker->time('H:i:s'),
            'event_end' => $faker->time('H:i:s'),
            'contact_email' => $faker->unique()->safeEmail,
            'contact_email_additional' => $faker->unique()->safeEmail,
            'event_description' => $eventDescription,
            'event_description_additional' => $faker->randomElement([
                'Dodatkowe informacje dostępne na stronie internetowej',
                'Wydarzenie będzie tłumaczone na język migowy',
                'Dla uczestników przewidziane są certyfikaty',
                'Jedzenie doliczone w cenie biletu',
                'Wstęp tylko dla osób pełnoletnich',
                'Wydarzenie dla rodzin',
            ]),
            'event_location' => $hall->id,
            'organizer_id' => $randomOrganizer,
            'image_path' => $faker->randomElement([
                'demo/posters/example1.jpg',
                'demo/posters/example2.jpg',
                'demo/posters/example3.jpg',
                'demo/posters/example4.jpg',
                'demo/posters/example5.jpg',
                'demo/posters/example6.jpg',
                'demo/posters/example7.jpg',
                'demo/posters/example8.jpg',
            ]),
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
