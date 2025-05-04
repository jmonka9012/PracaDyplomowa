<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizerDetailsRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_nip' => 'required|string|max:20',
            'company_country' => 'required|string|alpha|max:100',
            'company_city' => 'required|string|alpha|max:100',
            'company_zip_code' => 'required|string|max:20',
            'company_street' => 'required|string|max:255',   
            
            'phone_number' => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-\(\)]{7,20}$/' //nr. telefonu, opcjolany kod kraju (+48 np)
            ],

            'bank_account' => [
                'required',
                'string',
                'regex:/^([A-Z]{2}[0-9]{2})?[A-Z0-9]{11,30}$/', // IBAN miedzynarodowy, opcjonalnie 2 znaki kraju
                'max:34'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'To pole jest wymagane',
            'max' => 'Maksymalna wielkoś tego pola to :max znaków',
            'company_city.alpha' => 'Tylko litery są dozwolone w tym polu',
            'phone_number.regex' => 'Numer telefonu ma nieprawidłowy format.',
            'bank_account.regex' => 'Numer konta bankowego ma nieprawidłowy format, prosimy o numer konta w formacie IBAN'
        ];
    }
}
