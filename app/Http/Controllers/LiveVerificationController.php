<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LiveVerificationController extends Controller
{

    public function userExists(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'string|nullable',
        ]);
        $fieldType = filter_var($credentials['name'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        $userExist = User::where($fieldType, $credentials['name'])->exists();

        if ($userExist) {
            return response()->json([
/*                'valid' => 'true',*/
                'message' => 'użytkownik istnieje'
            ]);
        }
/*
        return response()->json([
            'valid' => 'false',
        ]);*/
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
