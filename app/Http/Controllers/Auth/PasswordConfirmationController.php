<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;

class PasswordConfirmationController extends Controller
{

    public function confirmPassword(Request $request) 
    { 
      $request->validate([
            'password' => 'required|string',
      ]);
      
      $user = $request->user();

      if(Hash::check($request->password, $user->password)) {
            
            $request->session()->put('auth.password_confirmed_at', time());
            
            return back()->with([
                  'confirmed' => true,
            ]);
      }

      return back()->withErrors([
            'password' => 'Nieprawidłowe hasło',
      ]);
    }
}
