<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class LoginUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Forms', [
            'message' => 'Logowanie',
            'csrf_token' => csrf_token(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $remember = $request->has('remember');

    if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']], $remember)) {
        $request->session()->regenerate();
        return redirect()->route('my-account');
    }

        return back()->withErrors([
            'login' => 'Podane dane są niepoprawne.',
        ]);
    }
}
