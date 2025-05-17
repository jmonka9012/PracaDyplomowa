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
        ->sortByDesc('created_at');

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

    public function getOrganizerStatus()
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Użytkownik nie zalogowany'
                ], 401);
            }

            $organizerData = $user->organizer;

            if (!$organizerData) {
                return response()->json([
                    'success' => true,
                    'is_organizer_account' => false,
                    'message' => 'Użytkownik nie jest organizatorem'
                ], 404);
            }

            $response = [
                'success' => true,
                'is_organizer_account' => true,
                'status' => $organizerData->account_status,
            ];

            switch($organizerData->account_status){
                case 'verified':
                    $response['organizer_details'] = [
                        'company_name' => $organizerData->company_name,
                        'phone_number' => $organizerData->phone_number,
                        'address' => $organizerData->getFullAddress(),
                        'bank_account_number' => $organizerData->bank_account_number,
                        'tax_number' => $organizerData->tax_number,
                    ];
                    break;

                case 'pending':
                    $response['message'] = 'Jesteśmy w trakcie weryfikowania konta, jeśli będzie taka potrzeba, skontaktujemy się, proszę czekać.';
                    break;
                     
                case 'denied':
                    $response['message'] = 'Konto zostało odrzucone';
                    break;
                        
                default:
                    $response['message'] = 'Brak statusu konta, proszę odświeżyć stronę, w razie dalszego braku informacji proszę skontaktować się z administracją.';
                    break;
            }

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve organizer status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}