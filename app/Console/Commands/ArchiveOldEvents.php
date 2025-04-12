<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ArchiveOldEvents extends Command
{
    protected $signature = 'events:archive';
    protected $description = 'Archives events older than the cutoff date';

    public function handle()
    {
        $cutoffDate = now()->subMonth();

        DB::insert('
        INSERT INTO events_archive
        (id, event_name, event_additional_url, event_date, event_start, event_end, contact_email, contact_email_additional, event_description, event_description_additional, event_location, image_path)
        SELECT id, event_name, event_additional_url, event_date, event_start, event_end, contact_email, contact_email_additional, event_description, event_description_additional, event_location, image_path
        FROM events
        WHERE event_date < ?
        ', [$cutoffDate]);

        $archivedEventIds = DB::table('events')
        ->where('event_date', '<', $cutoffDate)
        ->pluck('id')
        ->toArray();

        DB::insert('
        INSERT INTO event_seats_archive
        (id, event_id, hall_section_id, seat_row, seat_number, price, status)
        SELECT id, event_id, hall_section_id, seat_row, seat_number, price, status
        FROM event_seats
        WHERE event_id IN ('.implode(',', $archivedEventIds).')
        ');

        DB::insert('
        INSERT INTO event_standing_tickets_archive
        (id, event_id, hall_section_id, price, capacity, sold)
        SELECT id, event_id, hall_section_id, price, capacity, sold
        FROM event_standing_tickets
        WHERE event_id IN ('.implode(',', $archivedEventIds).')
        ');

        DB::insert('
        INSERT INTO tickets_archive
        (id, event_id, user_id, seat, hall_section, insured)
        SELECT id, event_id, user_id, seat, hall_section, insured
        FROM tickets
        WHERE event_id IN ('.implode(',', $archivedEventIds).')
        ');

       DB::delete('DELETE FROM events WHERE event_date < ?', [$cutoffDate]);
    }
}
