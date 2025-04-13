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
        ];
    }
}
