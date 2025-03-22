<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;

class RegisterUserController extends Controller{

    public function create(): Response{
        return Inertia::render('Forms', [
            'message' => 'Rejestracja',
            'csrf_token' => csrf_token(),
        ]);
    }

    public function store(Request $request): RedirectResponse{
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:'.User::class,
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.unique' => 'Istnieje już konto z tą nazwom',
            'password.confirmed'=> 'Hasła nie są takie same',
            'email.unique'=> 'Istnieje już konto z tym emailem',
            'password.min'=> 'Hasło jest zbyt krótkie',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        Mail::to($user->email)->send(new VerifyEmail($user));

        Auth::login($user);

        return redirect()->route('my-account');
    }

}
