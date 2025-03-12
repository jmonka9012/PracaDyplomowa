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
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('contact'); //na razie ta strona, tak jak w RegisterUserController.php nie ma innej
        }

        return back()->withErrors([
            'email' => 'Podane dane są niepoprawne.',
        ]);
    }

    // Logout, nie mamy jeszcze przycisku do wylogowania
    // public function destroy(Request $request): RedirectResponse
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return redirect()->route('home');
    // }
}
