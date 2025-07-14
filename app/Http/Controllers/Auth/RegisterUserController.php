<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OrganizerInformation;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\OrganizerDetailsRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class RegisterUserController extends Controller{

    public function create(): Response{
        return Inertia::render('SignIn', [
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

        if ($request->organizer_request) {
            $organizerData = $request->organizer_details;

            $formRequest = new OrganizerDetailsRequest();
            $rules       = $formRequest->rules();
            $messages    = $formRequest->messages();

            $validator = Validator::make((array) $organizerData, $rules, $messages);

            $validatedOrganizerData = $validator->validated();

            OrganizerInformation::Create([
                'user_id' => $user->id,
                'company_name' => $validatedOrganizerData['company_name'],
                'phone_number' => $validatedOrganizerData['phone_number'],
                'tax_number' => $validatedOrganizerData['company_nip'],
                'address_country' => $validatedOrganizerData['company_country'],
                'address_city' => $validatedOrganizerData['company_city'],
                'address_zip_code' => $validatedOrganizerData['company_zip_code'],
                'address_street' => $validatedOrganizerData['company_street'],
                'bank_account_number' => $validatedOrganizerData['bank_account'],
            ]);
        }

        Mail::to($user->email)->send(new VerifyEmail($user));

        Auth::login($user);

        return redirect()->route('my-account');
    }

    public function forgotPasswordShow(){
        return Inertia::render('ForgotPassword', [
            //
        ]);
    }

    public function sendResetEmailLink(Request $request)
    {
        $request -> validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetFormShow(Request $request, $token = null)
    {
        return Inertia::render('ForgotPasswordForm', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetFormStore(Request $request)
    {
        
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
