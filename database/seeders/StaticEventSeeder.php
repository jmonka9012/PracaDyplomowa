<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Events\Event;
use App\Models\Events\Genre;
use App\Models\Hall;
use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
class StaticEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hall = Hall::with('sections')->first();

        if (!$hall) {
            $this->command->error('No hall found, run migration first.');
            return;
        }

        $eventDescription =
            '<p><img src="/storage/event_images/placeholder.jpg"></p>
            <hr>
            <div id="Content">
            <div id="bannerL">
            <div id="lipsumcom_left_siderail_1" align="center" data-google-query-id="COrJj9r40owDFZ3MOwIdsHAG1w" data-freestar-ad="__300x600 __400x225"></div>
            <div id="lipsumcom_left_siderail_2" align="center" data-freestar-ad="__300x600"></div>
            </div>
            <div id="bannerR">
            <div id="lipsumcom_right_siderail_1" align="center" data-google-query-id="COvJj9r40owDFZ3MOwIdsHAG1w" data-freestar-ad="__300x600 __400x225"></div>
            <div id="lipsumcom_right_siderail_2" align="center" data-freestar-ad="__300x600"></div>
            </div>
            <div>
            <div id="lipsum">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer pellentesque massa eu leo dictum, vel condimentum diam volutpat. Aenean eu porttitor massa, quis malesuada tellus. Vestibulum lobortis, ex ac sagittis consequat, sapien risus mattis ante, ut pretium eros urna eu sapien. Vivamus eu mollis nunc, quis iaculis nunc. Donec semper purus diam, consectetur porttitor justo pretium in. Pellentesque dictum dui at ipsum consequat, a convallis enim mollis. Etiam facilisis blandit turpis, varius rutrum lorem rutrum vitae. Quisque a massa consequat, congue risus a, rutrum dolor.</p>
            <p>Quisque ut lorem nisi. Vestibulum ornare a dolor sollicitudin consequat. Ut ornare eleifend arcu in finibus. Cras sed efficitur nisl, quis tempor urna. Curabitur tellus ipsum, mollis vitae ex ut, ultrices vestibulum massa. Suspendisse non magna eget augue porta dignissim id eget neque. Duis eget sollicitudin velit, vitae posuere dui. Etiam tincidunt facilisis ipsum eu faucibus. Proin posuere, mauris in imperdiet venenatis, purus augue elementum nibh, quis tempor ante lorem at libero. In hac habitasse platea dictumst. Aenean porttitor iaculis augue non sagittis. Donec placerat faucibus metus eget cursus. Integer eu luctus quam. Vestibulum sollicitudin at sem auctor aliquet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum lobortis, turpis sed placerat blandit, dui nulla accumsan felis, vel dignissim nisi est et risus.</p>
            </div>
            </div>
            </div>';

        $events =[
            [
                'event_name' => 'David Bowie 2020s',
                'event_date' => now()->addMonth(),
                'event_start' => '09:00:00',
                'event_end' => '17:00:00',
                'contact_email' => 'david@bowie.com',
                'contact_email_additional' => 'agent@bowie.com',
                'event_description' => $eventDescription,
                'event_description_additional' => 'Fajnie będzie ogółem',
                'event_location' => 1,
                'genres' =>['Rock', 'Avant-Garde', 'Rock Alternatywny'],
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => false,
            ],
            [
                'event_name' => 'David Bowie 2070s',
                'event_date' => now()->addYears(50),
                'event_start' => '00:00:00',
                'event_end' => '24:00:00',
                'contact_email' => 'greatemperorbowie@gov.com',
                'contact_email_additional' => 'hismajesty@gov.com',
                'event_description' => $eventDescription,
                'event_description_additional' => 'He Has Risen',
                'event_location' => 2,
                'genres' =>['Rock', 'Avant-Garde', 'Rock Alternatywny'],
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => false,
            ],
            [
                'event_name' => 'Motorhead 2025',
                'event_date' => now()->addMonths(5),
                'event_start' => '12:00:00',
                'event_end' => '17:00:00',
                'contact_email' => 'lemmy@motorhead.com',
                'contact_email_additional' => 'agent@motorhead.com',
                'event_description' => $eventDescription,
                'event_description_additional' => 'Lemmy będzie',
                'event_location' => 1,
                'genres' =>['Metal', 'Rock', 'Heavy Metal', 'Thrash Metal'],
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => false,
            ],
            [
                'event_name' => 'Opeth Reveries 202X',
                'event_date' => now()->addMonths(8),
                'event_start' => '12:00:00',
                'event_end' => '13:00:00',
                'contact_email' => 'mikael@opeth.com',
                'contact_email_additional' => 'agent@opeth.com',
                'event_description' => $eventDescription,
                'event_description_additional' => 'Growle będą',
                'event_location' => 2,
                'genres' =>['Metal', 'Rock', 'Death Metal', 'Progressive Death Metal'],
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => 1
            ],
            [
                'event_name' => 'Acid Bath.mp4',
                'event_date' => now()->addYear(),
                'event_start' => '06:06:06',
                'event_end' => '07:07:07',
                'contact_email' => 'dmca@takedown.com',
                'contact_email_additional' => 'youtube@upload.com',
                'event_description' => $eventDescription,
                'event_description_additional' => 'Pierwsze uderzenie konta youtube',
                'event_location' =>1,
                'genres' =>['Metal', 'Rock', 'Sludge Metal'],
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => 1
            ],
            [
                'event_name' => 'System Of A Down Reunion',
                'event_date' => now()->addYears(2),
                'event_start' => '10:00:00',
                'event_end' => '15:00:00',
                'contact_email' => 'serji@soad.com',
                'contact_email_additional' => 'serji2real@soad.com',
                'event_description' => $eventDescription,
                'event_description_additional' => 'tell me lies tell me sweet little lies',
                'event_location' =>2,
                'genres' =>['Metal', 'Rock', 'Nu Metal'],
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => 0
            ],
            
            [
                'event_name' => 'Archive Test Event',
                'event_date' => now()->subYears(value: 2),
                'event_start' => '10:00:00',
                'event_end' => '15:00:00',
                'contact_email' => 'archive@test.com',
                'contact_email_additional' => 'archive@test.com',
                'event_description' => $eventDescription,
                'event_description_additional' => 'archive@test.com',
                'event_location' =>2,
                'genres' =>['Metal', 'Rock'],
                'image_path' => 'event_images/placeholder.jpg',
                'pending' => 1
            ],
        ];

        foreach ($events as $eventData) {
            $genres = $eventData['genres'] ?? [];
            unset($eventData['genres']);

            $event = Event::create($eventData);
            
            $eventHall = Hall::with('sections')->find($eventData['event_location']);
            
            if (!empty($genres)) {

                $genreIds = Genre::whereIn('genre_name', $genres)
                    ->pluck('id')
                    ->all();
                
                if (!empty($genreIds)) {
                    $event->genres()->attach($genreIds);
                } else {
                    logger()->warning("No matching genres found for: " . implode(', ', $genres));
                }
            }

            if (!$eventHall) {
                $this->command->error("Hall not found for event: {$event->event_name}");
                continue;
            }
        
            foreach ($eventHall->sections as $section) {
                if ($section->section_type == 'seat') {
                    for ($row = 1; $row <= $section->row; $row++) {
                        for ($col = 1; $col <= $section->col; $col++) {
                                $status = ($event->pending == 0) 
                                ? ['available', 'sold'][array_rand(['available', 'sold'])]
                                : 'available';

                                EventSeat::create([
                                    'hall_section_id' => $section->id,
                                    'event_id' => $event->id,
                                    'seat_row' => $row,
                                    'seat_number' => $col,
                                    'price' => 10.50,
                                    'status' => $status,
                                ]);
                        }
                    }
                } else {
                    EventStandingTicket::create([
                        'hall_section_id' => $section->id,
                        'event_id' => $event->id,
                        'capacity' => $section->capacity,
                        'sold' => ($event->pending == 0) ? rand(0, $section->capacity) : 0,
                        'price' => 5.50,
                    ]);
                }
            }
        }
    }
}

