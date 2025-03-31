<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LiveVerificationController extends Controller
{

    public function userExists(Request $request) 
    {   
        $credentials = $request->validate([
            'login' => 'required|string',
        ]);
        $fieldType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $userExist = User::where($fieldType, $credentials['login'])->exists();

        if ($userExist) {
            return response()->json([
                'valid' => 'true'
            ]);
        }

        return response()->json([
            'valid' => 'false',
            'message' => 'użytkownik nie istnieje'
        ]);
    }

    public function isEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);

        $email = trim($request->input('email'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'valid' => 'false',
                'message' => 'Nieprawdiłowy email,'
            ], 422);
        }

        return response()->json([
            'valid' => 'true'
        ]);
    }

}
