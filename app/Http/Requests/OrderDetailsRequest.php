<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;
class OrderDetailsRequest extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name'=> 'required|max:255',
            'email' => 'required|email|max:255',
            'country' => 'required|string|alpha|max:100',
            'city' => 'required|string|alpha|max:100',
            'street' => 'required|string|max:255',
            'house_number' => 'required|string|max:20',
            'zip_code' => 'required|string|max:20',
            'make_account' => 'nullable|boolean',
            'save_data' => 'nullable|boolean',
            'company' => 'sometimes|string|max:255',
            'tax_number' => 'sometimes|string|max:20',

            'phone' => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-\(\)]{7,20}$/' //nr. telefonu, opcjolany kod kraju (+48 np)
            ]
        ];

        if ($this->make_account){
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
            $rules['name'] = ['name' => 'required', 'string', 'max:255', 'unique:'.User::class];
            $rules['email'] = 'unique:'.User::class;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
                'required' => 'Pole jest wymagane',
                'max' => 'Maksymalna długość to :max znaków',
                'string' => 'Wartość musi być tekstem',
                'alpha' => 'Dozwolone są tylko litery',

                'email.email' => 'Nieprawidłowy format adresu e-mail',
                'email.unique'=> 'Istnieje już konto z tym emailem',

                'country.alpha' => 'Nazwa kraju może zawierać tylko litery',
                'city.alpha' => 'Nazwa miasta może zawierać tylko litery',

                'phone.regex' => 'Nieprawidłowy format numeru telefonu. Akceptowane formaty: +48 123 456 789 lub 123456789',
            
                'password.confirmed'=> 'Hasła nie są takie same',
                'password.min'=> 'Hasło jest zbyt krótkie',

                'name.unique' => 'Istnieje już konto z tą nazwą',
            ];

    }
}
