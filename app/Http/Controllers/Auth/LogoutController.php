<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function destroy(Request $request): RedirectResponse
    {
        $previousUrl = $request->headers->get('referer');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($this->isUrlAccessibleToGuests($previousUrl)) {
            return redirect()->to($previousUrl);
        }

        return redirect()->route('home');
    }

    protected function isUrlAccessibleToGuests(string $url): bool
    {
        $guestAccessibleRoutes = [
            'home',
            'about',
            'contact',
        ];

        foreach ($guestAccessibleRoutes as $route) {
            if (str_contains($url, route($route))) {
                return true;
            }
        }

        return false;
    }
}