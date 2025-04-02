<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterUserRequest;

class RegisterUserController extends Controller{

    public function create(): Response{
        return Inertia::render('Forms', [
            'message' => 'Rejestracja',
            'csrf_token' => csrf_token(),
        ]);
    }

    public function store(RegisterUserRequest $request): RedirectResponse{
        
        $validatedData = $request->validated(); 

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'first_name'=> $validatedData['first_name'],
            'last_name'=> $validatedData['last_name'],
        ]);

        Mail::to($user->email)->send(new VerifyEmail($user));

        Auth::login($user);

        return redirect()->route('my-account');
    }

}
