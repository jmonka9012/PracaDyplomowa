<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class RegisterUserRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:'.User::class,
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'first_name' => 'required|max:255',
            'last_name'=> 'required|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'name.unique' => 'Istnieje już konto z tą nazwą',
            'name.required'=> 'Nie podano nazwy użytkownika',
            'name.max'=> 'Nazwa użytkownika jest zbyt długa',
            'email.unique'=> 'Istnieje już konto z tym emailem',
            'email.required'=> 'Nie podano emailu',
            'email.max'=> 'Podany email jest zbyt długi',
            'email.email'=> 'Nieprawidłowy adres e-mail.',
            'password.confirmed'=> 'Hasła nie są takie same',
            'password.min'=> 'Hasło jest zbyt krótkie',
            'first_name.required'=> 'Nie podano imienia',
            'first_name.max'=> 'Imie jest zbyt długie (Max. 255 znaków)',
            'last_name.required'=> 'Nie podano nazwiska',
            'last_name.max'=> 'Nazwisko jest zbyt długie (Max. 255 znaków)',
        ];
    }
}
