<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail; 

class EmailVerificationController extends Controller
{
      public function show(Request $request)
      {
          return redirect()->route('my-account');
      }

    public function verify(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$request->hasValidSignature()) {
            abort(403, 'Link wygasł, poproś o nowy link w zakładzce Moje Konto');
        }

        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('my-account')->with('status', 'Email zweryfikowany');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('my-account');
        }

        Mail::to($request->user()->email)->send(new VerifyEmail($request->user()));

        return back()->with('status', 'Email został wysłany');
    }
}