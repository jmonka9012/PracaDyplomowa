<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Events\Event;
use App\Models\Events\EventArchived;
use App\Models\EventSeats\EventSeat;
use App\Models\EventSeats\EventSeatArchived;
use App\Models\EventStandingTickets\EventStandingTicket;
use App\Models\EventStandingTickets\EventStandingTicketArchived;

class ArchiveOldEvents extends Command
{
    protected $signature = 'events:archive';
    protected $description = 'Archives events older than the cutoff date using Eloquent';

    public function handle()
    {
        $cutoffDate = now()->subMonth();

        DB::transaction(function () use ($cutoffDate) {
            $events = Event::where('event_date', '<', $cutoffDate)->get();

            if ($events->isEmpty()) {
                $this->info('No events to archive.');
                return;
            }

            $eventIds = $events->pluck('id')->toArray();

            $allPivotRows = collect();

            foreach ($events as $event) {
                $archiveData = $event->toArray();
                if (isset($archiveData['pending'])) {
                    unset($archiveData['pending']);
                }

                $archiveEvent = new EventArchived();
                $archiveEvent->fill($archiveData);
                $archiveEvent->id = $event->id;
                $archiveEvent->save();

                foreach ($event->seats as $seat) {
                    $seatData = $seat->toArray();
                    $archiveSeat = new EventSeatArchived();
                    $archiveSeat->fill($seatData);
                    $archiveSeat->save();
                }

                foreach ($event->standingTickets as $standingTicket) {
                    $standingTicketData = $standingTicket->toArray();
                    $archiveStandingTicket = new EventStandingTicketArchived();
                    $archiveStandingTicket->fill($standingTicketData);
                    $archiveStandingTicket->save();
                }

                $genrePivotRows = DB::table('event_genres')
                    ->where('event_id', $event->id)
                    ->get();
                $this->info("Event ID {$event->id} - Found {$genrePivotRows->count()} genre pivot rows");
                $allPivotRows = $allPivotRows->merge($genrePivotRows);
            }

            $uniquePivotRows = $allPivotRows->unique(function ($item) {
                return $item->event_id . '-' . $item->genre_id;
            })->map(function ($item) {
                return [
                    'event_id' => $item->event_id,
                    'genre_id' => $item->genre_id,
                ];
            })->values()->toArray();

            $this->info('Unique pivot rows: ' . json_encode($uniquePivotRows));

            if (!empty($uniquePivotRows)) {
                DB::table('event_genres_archive')->insertOrIgnore($uniquePivotRows);
            } else {
                $this->info('No unique pivot rows to insert.');
            }

            $insertedCount = DB::table('event_genres_archive')->count();
            $this->info("Number of rows in event_genres_archive: {$insertedCount}");

            DB::table('event_genres')->whereIn('event_id', $eventIds)->delete();
            EventSeat::whereIn('event_id', $eventIds)->delete();
            EventStandingTicket::whereIn('event_id', $eventIds)->delete();
            Event::where('event_date', '<', $cutoffDate)->delete();
        });

        $this->info('Archiving complete.');
    }
}
