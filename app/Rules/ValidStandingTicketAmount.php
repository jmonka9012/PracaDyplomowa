<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidStandingTicketAmount implements Rule
{
    protected $index;
    protected $request;
    protected $message = 'Nieprawidłowa ilość biletów stojących.';

    public function __construct($index, $request)
    {
        $this->index = $index;
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $standingTicketId = $this->request->input("standing_tickets.{$this->index}.id");

        $standingTicket = DB::table('event_standing_tickets')
            ->where('id', $standingTicketId)
            ->where('event_id', $this->request->input('event_id'))
            ->first();

        if (!$standingTicket) {
            $this->message = 'Nieprawidłowa sekcja biletów stojących.';
            return false;
        }

        $available = $standingTicket->capacity - $standingTicket->sold - $standingTicket->reserved;

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
}
