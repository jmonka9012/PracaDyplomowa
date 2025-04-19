<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Events\Event;

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
                'valid' => false,
                'message' => 'użytkownik istnieje'
            ]);
        }

        return response()->json([
            'valid' => true,
        ]);
    }

    public function isEmail(Request $request)
    {
        $request->validate([
            'email' => 'string|nullable',
        ]);

        $email = trim($request->input('email'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'valid' => false,
                'message' => 'Nieprawidłowy adres e-mail.'
            ], 200);
        }

        if (User::where('email', $email)->exists()) {
            return response()->json([
                'valid' => false,
                'message' => 'Użytkownik z takim adresem e-mail już istnieje.'
            ], 200);
        }

        return response()->json([
            'valid' => true
        ], 200);
    }

    public function eventTimeTaken(request $request)
    {
        $date = $request->validate([
            'event_date' => 'required|date|after:+'.now()->addDays(6),
        ],
[
        'event_date.after'=> 'Potrzebujemy przynajmniej tygodnia w celach administracyjnych, proszę wybrać datę tydzień w przyszłość minimum.'
        ]);

        $dateTaken = Event::where('event_date', $date['event_date'])->exists();

        if ($dateTaken) {
            return response()->json([
                'valid' => false,
                'message' => 'dzień '
            ]);
        }

        return response()->json([
            'valid' => true,
        ]);
    }
}
