<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;


class MyAccountDataChangeRequest extends FormRequest
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
            'first_name' => 'string|max:255|nullable',
            'last_name'=> 'string|max:255|nullable',
            'email' => 'nullable|string|email|max:255|unique:'.User::class,
            'password' => ['nullable', Rules\Password::defaults()],

            'country' => 'nullable|string|alpha|max:100',
            'city' => 'nullable|string|alpha|max:100',
            'street' => 'nullable|string|max:255',
            'house_number' => 'nullable|string|max:20',
            'zip_code' => 'nullable|string|max:20',

            'phone' => [
                'nullable',
                'string',
                'regex:/^\+?[0-9\s\-\(\)]{7,20}$/' //nr. telefonu, opcjolany kod kraju (+48 np)
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'first_name.max' => 'Podane imie jest zbyt długie',
            'last_name.max' => 'Podane nazwisko jest zbyt długie',
            
            'email.email' => 'Nieprawidłowy adres e-mail',
            'email.unique'=> 'Istnieje już konto z tym emailem',
            'email.max'=> 'Podany email jest zbyt długi',

            'country.alpha' => 'Nazwa kraju może zawierać tylko litery',
            'city.alpha' => 'Nazwa miasta może zawierać tylko litery',

            'phone.regex' => 'Nieprawidłowy format numeru telefonu. Akceptowane formaty: +48 123 456 789 lub 123456789',
        ];
    }
}
