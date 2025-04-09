<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Events\Event;
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

        $events =[
            [
                'event_name' => 'David Bowie 2020s',
                'event_url' => 'https://open.spotify.com/artist/0oSGxfWSnnOXhD2fKuz2Gy',
                'event_date' => now()->addMonth(),
                'event_start' => '09:00:00',
                'event_end' => '17:00:00',
                'contact_email' => 'david@bowie.com',
                'contact_email_additional' => 'agent@bowie.com',
                'event_description' => 'Ziggy Stardust to fajny gość',
                'event_description_additional' => 'Fajnie będzie ogółem',
                'event_location' => 1,
                'image_path' => 'event_images/placeholder.jpg',
            ],
            [
                'event_name' => 'David Bowie 2070s',
                'event_url' => 'https://bowie-emperor.gov.com/hail-the-king',
                'event_date' => now()->addYears(50),
                'event_start' => '00:00:00',
                'event_end' => '24:00:00',
                'contact_email' => 'greatemperorbowie@gov.com',
                'contact_email_additional' => 'hismajesty@gov.com',
                'event_description' => 'Kult Kult Kult Kult Kult',
                'event_description_additional' => 'He Has Risen',
                'event_location' => 2,
                'image_path' => 'event_images/placeholder.jpg',
            ],
            [
                'event_name' => 'Motorhead 2025',
                'event_url' => 'https://open.spotify.com/artist/1DFr97A9HnbV3SKTJFu62M',
                'event_date' => now()->addMonths(5),
                'event_start' => '12:00:00',
                'event_end' => '17:00:00',
                'contact_email' => 'lemmy@motorhead.com',
                'contact_email_additional' => 'agent@motorhead.com',
                'event_description' => 'The Ace of Spades has arrived',
                'event_description_additional' => 'Lemmy będzie',
                'event_location' => 1,
                'image_path' => 'event_images/placeholder.jpg',
            ],
            [
                'event_name' => 'Opeth Reveries 202X',
                'event_url' => 'https://open.spotify.com/artist/0ybFZ2Ab08V8hueghSXm6E',
                'event_date' => now()->addMonths(8),
                'event_start' => '12:00:00',
                'event_end' => '13:00:00',
                'contact_email' => 'mikael@opeth.com',
                'contact_email_additional' => 'agent@opeth.com',
                'event_description' => 'Opeth robi znowu dobrą muzykę(?!)',
                'event_description_additional' => 'Growle będą',
                'event_location' => 2,
                'image_path' => 'event_images/placeholder.jpg',
            ],
            [
                'event_name' => 'Acid Bath.mp4',
                'event_url' => 'https://open.spotify.com/artist/3n5jeTRWZEbTPJWyHSYUqn',
                'event_date' => now()->addYear(),
                'event_start' => '06:06:06',
                'event_end' => '07:07:07',
                'contact_email' => 'dmca@takedown.com',
                'contact_email_additional' => 'youtube@upload.com',
                'event_description' => 'Acid Bath znowu usunięte z youtube',
                'event_description_additional' => 'Pierwsze uderzenie konta youtube',
                'event_location' =>1,
                'image_path' => 'event_images/placeholder.jpg',
            ],
            [
                'event_name' => 'System Of A Down Reunion',
                'event_url' => 'https://open.spotify.com/artist/5eAWCfyUhZtHHtBdNk56l1',
                'event_date' => now()->addYears(2),
                'event_start' => '10:00:00',
                'event_end' => '15:00:00',
                'contact_email' => 'serji@soad.com',
                'contact_email_additional' => 'serji2real@soad.com',
                'event_description' => 'Nowy album anytime now, stay tuned.',
                'event_description_additional' => 'tell me lies tell me sweet little lies',
                'event_location' =>2,
                'image_path' => 'event_images/placeholder.jpg',
            ],
            [
                'event_name' => 'Archive Test Event',
                'event_url' => 'https://open.spotify.com/artist/5eAWCfyUhZtHHtBdNk56l1',
                'event_date' => now()->subYears(value: 2),
                'event_start' => '10:00:00',
                'event_end' => '15:00:00',
                'contact_email' => 'archive@test.com',
                'contact_email_additional' => 'archive@test.com',
                'event_description' => 'archive@test.com',
                'event_description_additional' => 'archive@test.com',
                'event_location' =>2,
                'image_path' => 'event_images/placeholder.jpg',
            ],
        ];

        foreach ($events as $eventData) {
            $event = Event::create($eventData);
            
            $eventHall = Hall::with('sections')->find($eventData['event_location']);
        
            if (!$eventHall) {
                $this->command->error("Hall not found for event: {$event->event_name}");
                continue;
            }
        
            foreach ($eventHall->sections as $section) {
                if ($section->section_type == 'seat') {
                    for ($row = 1; $row <= $section->row; $row++) {
                        for ($col = 1; $col <= $section->col; $col++) {
                            EventSeat::create([
                                'hall_section_id' => $section->id,
                                'event_id' => $event->id,
                                'seat_row' => $row,
                                'seat_number' => $col,
                                'price' => 10.50,
                                'status' => 'available',
                            ]);
                        }
                    }
                } else {
                    EventStandingTicket::create([
                        'hall_section_id' => $section->id,
                        'event_id' => $event->id,
                        'capacity' => $section->capacity,
                        'price' => 5.50,
                    ]);
                }
            }
        }
    }
}

