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


    //Tu jest do renderowania front endu, trzeba dodac frontend
    //class RegisterUserController extends Controller {
    //    public function create(): Response{
    //        return Inertia::render('Strona');
    //    }
    //}

    public function store(Request $request): RedirectResponse{
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //event(new Registered($user)); nie ma jeszcze eventu, trzeba napisac event ktory wysle email z weryfikacja kiedy to zrobimy

        Auth::login($user);

        //return redirect()->route('Strona'); nie ma strony na ktora moze to przekierowywac
    }

}