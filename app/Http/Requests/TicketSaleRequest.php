<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidStandingTicketAmount;

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
    return [
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
            Rule::exists('event_standing_tickets', 'id')->where('event_id', $this->input('event_id')),
        ],

        'standing_tickets.*.amount' => [
            'sometimes',
            'integer',
            'min:1',
            function ($attribute, $value, $fail) {
                $index = explode('.', $attribute)[1];
                $rule = new ValidStandingTicketAmount($index, $this);
                if (!$rule->passes($attribute, $value)) {
                    $fail($rule->message());
                }
            },
        ],
    ];       
}

    public function messages(): array
    {
        return [
            'require' => 'To pole jest wymagane.',
            'seats.*.id.exists' => 'Wybrane miejsce jest nieprawidłowe lub niedostępne dla tego wydarzenia.'
            // todo reszta bo nie wiem które będą sie wyśiwetały a ktore nie '' => '',
        ];
    }
}
