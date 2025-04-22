<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Events\Event;

class UniqueEventLocationAndDate implements Rule
{
    protected $eventDate;
    protected $currentEventId;

    public function __construct($eventDate, $currentEventId = null)
    {
        $this->eventDate = $eventDate;
        $this->currentEventId = $currentEventId;
    }

    public function passes($attribute, $value)
    {
        $query = Event::where('event_date', $this->eventDate)
                      ->where('event_location', $value);

        // logika jeśli będzie to kiedyś służyć do aktualizacji
        if ($this->currentEventId) {
            $query->where('id', '!=', $this->currentEventId);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'Sala w ten dzień już jest zarezerwowana, proszę wybrać inną sale';
    }
}
