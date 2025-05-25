<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidStandingTicketAmount implements Rule
{
    protected $index;
    protected $request;
    protected $message = 'Nieprawidłowa ilość biletów stojących.';
    protected $sectionId;

    public function __construct($index, $request)
    {
        $this->index = $index;
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $this->sectionId = $this->request->input("standing_tickets.{$this->index}.id");

        if (!$this->sectionId) {
            $this->message = 'Nieprawidłowa sekcja biletów stojących.';
            return false;
        }

        $ticket = DB::table('event_standing_tickets')
            ->where('id', $this->sectionId)
            ->where('event_id', $this->request->input('event_id'))
            ->first();

        if (!$ticket) {
            $this->message = 'Nieprawidłowa sekcja biletów stojących.';
            return false;
        }

        $available = $ticket->capacity - $ticket->sold - $ticket->reserved;

        if ($value > $available) {
            $this->message = "Zostało tylko {$available} miejsc w tej sekcji (Wybrano: {$value}).";
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }

    public function getSectionId()
    {
        return $this->sectionId;
    }
}
