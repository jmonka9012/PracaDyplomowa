<?php

namespace App\Http\Controllers;

use App\Http\Resources\SupportTicketResource;
use App\Models\SupportTicket;
use Inertia\Inertia;
use App\Http\Requests\MyAccountDataChangeRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Enums\UserRole;

class MyAccountController extends Controller
{
    public function index()
    {
        $supportTickets = SupportTicket::where('user_id', auth()->id())->get()
        ->sortBy('created_at');

        return Inertia::render('My-Account', [
            'support_tickets' => SupportTicketResource::collection($supportTickets),
        ]);
    }

    public function store(MyAccountDataChangeRequest $request)
    {
        $emailWasChanged = false;

        if (now()->timestamp - $request->session()->get('auth.password_confirmed_at', 0) > 600) {
            abort(403, 'Potwierdzenie hasła wygasło, proszę spróbuj ponownie.');
        }

        $user = $request->user();
        $validatedData = $request->validated(); 

        $updateData = array_filter($validatedData, function ($value) {
            return $value !== null;
        });
    
        if (isset($updateData['password'])) {
            $updateData['password'] = Hash::make($updateData['password']);
        }

        if (isset($updateData['email'])) {
            $updateData['email_verified_at'] = null;
            $user->role = UserRole::UNVERIFIED_USER->value;
            $user->permission_level = UserRole::UNVERIFIED_USER->permissionLevel();
            $user->save();

            $emailWasChanged = true;
        }

        if (!empty($updateData)) {
            $request->user()->update($updateData);

            if ($emailWasChanged) {
                Mail::to($user->email)->send(new VerifyEmail($user));
            }
            return back()->with('success','Profil zauktalizowany');
        }

        return back()->with('error','błąd');
    }
}