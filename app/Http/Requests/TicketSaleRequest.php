<?php

namespace App\Http\Requests;

use App\Models\EventSeats\EventSeat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidStandingTicketAmount;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
class TicketSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'event_id' => 'required|numeric|exists:events,id',

            'seats' => 'sometimes|array',
            'seats.*.id' => [
                'required',
                'numeric',
                Rule::exists('event_seats', 'id')->where(function ($query) {
                    return $query->where('status', 'available')
                                 ->where('event_id', $this->input('event_id'));
                }),
            ],

            'standing_tickets' => 'sometimes|array',
            'standing_tickets.*.id' => [
                'required',
                'numeric',
                Rule::exists('event_standing_tickets', 'id')
                    ->where('event_id', $this->input('event_id')),
            ],
        ];

        foreach ($this->input('standing_tickets', []) as $index => $ticket) {
            $rules["standing_tickets.$index.amount"] = [
                'sometimes',
                'integer',
                'min:1',
                new ValidStandingTicketAmount($index, $this),
            ];
        }
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $transformedErrors = [];

        $standingErrors = [];
        foreach ($this->input('standing_tickets', []) as $index => $ticket) {
            $sectionId = (string)($ticket['id'] ?? $index);
            $amountKey = "standing_tickets.$index.amount";
            $sectionKey = "standing_tickets.$index.id";

            if (isset($errors[$amountKey])) {
                $standingErrors[$sectionId] = $errors[$amountKey][0];
                unset($errors[$amountKey]);
            }

            if (isset($errors[$sectionKey])) {
                $standingErrors[$sectionId] = $errors[$sectionKey][0];
                unset($errors[$sectionKey]);
            }
        }

        if (!empty($standingErrors)) {
            $transformedErrors['standing_tickets'] = $standingErrors;
        }

        $seatErrors = [];
        foreach ($errors as $key => $messages) {
            if (str_starts_with($key, 'seats.')) {
                $parts = explode('.', $key);

                if (count($parts) >= 2 && is_numeric($parts[1])) {
                    $seatId = $parts[1];
                    $sectionId = (string)$this->getSectionIdForSeat($seatId);

                    if ($sectionId) {
                        $seatErrors[$sectionId] = "W danej sekcji wybrano zajęte już miejsce";
                        unset($errors[$key]);
                    } else {
                        $seatErrors[$seatId] = $messages[0];
                        unset($errors[$key]);
                    }
                } else {
                    $seatErrors[$key] = $messages[0];
                    unset($errors[$key]);
                }
            }
        }

        if (!empty($seatErrors)) {
            $transformedErrors['seats'] = $seatErrors;
        }

        foreach ($errors as $key => $messages) {
            $normalizedKey = preg_replace('/\.(id|amount)$/', '', $key);
            $transformedErrors[$normalizedKey] = $messages[0];
        }

        session()->flash('nested_errors', $transformedErrors);

        throw ValidationException::withMessages($transformedErrors);
    }

    public function messages(): array
    {
        return [
            'require' => 'To pole jest wymagane.',
            'seats.*.id.exists' => 'Wybrane miejsce jest nieprawidłowe lub niedostępne dla tego wydarzenia.'
            // todo reszta bo nie wiem które będą sie wyśiwetały a ktore nie '' => '',
        ];
    }

    private function getSectionIdForSeat($seatId)
    {
        $seat = EventSeat::find($seatId);
        return $seat ? $seat->hall_section_id : null;
    }

}
