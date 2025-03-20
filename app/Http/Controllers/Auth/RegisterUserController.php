<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

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
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        //event(new Registered($user)); nie ma jeszcze eventu, trzeba napisac event ktory wysle email z weryfikacja kiedy to zrobimy

        //Auth::login($user);

        return redirect()->route('home'); // nie ma strony na ktora moze to przekierowywac
    }

}