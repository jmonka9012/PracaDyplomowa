<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Enums\OrganizerAccountStatus;
use App\Http\Resources\UserAdminBrowserResource;
use App\Models\OrganizerInformation;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class ManageUsersController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.users', ['page' => 1] + $request->except('page'));
        }
        
        return Inertia::render('Admin/ManageUsers', $this->getPageData($request));
    }

    public function showData(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.users.data', ['page' => 1] + $request->except('page'));
        }

        return response()->json($this->getPageData($request));
    }


    public function deleteUser(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|numeric|exists:users,id'
        ]);

        try{
            DB::beginTransaction();
            

            $user = User::findOrFail($validatedData['user_id']);
            $user->delete(); 

            DB::commit();

            $usersPaginator = $this->getFilteredUsers($request);
            
            return redirect()->back()->with([
            'users' => UserAdminBrowserResource::collection($usersPaginator)
                ->response()
                ->getData(true)
        ]);} catch (\Exception $e){
            DB::rollBack();

            return response()->json([
                'user_deleted' => false,
                'message' => 'Użytkownik nie został usunięty',
            ]);
        }
    }
    
    public function getFilteredUsers(Request $request)
    {
        $query = User::withTicketCounts()
            ->with('organizer');
    
        if ($request->filled('name')) {
            $searchTerm = '%' . $request->name . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", [$searchTerm]);
            });
        }
    
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
    
        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }
        
        if ($request->filled('company_name')) {
        $query->whereHas('organizer', function($q) use ($request) {
            $q->where('company_name', 'like', '%' . $request->company_name . '%');
        });
        }

        if ($request->filled('account_status')) {
            $query->whereHas('organizer', function($q) use ($request) {
                $q->where('account_status', $request->account_status);
            });
        }
    
        return $query->paginate(20)
                    ->appends($request->except('page'));
    }

    public function getAccountStatusStats()
    {
        $counts = OrganizerInformation::selectRaw('account_status, count(*) as count')
            ->groupBy('account_status')
            ->pluck('count', 'account_status')
            ->toArray();
        
        $results = [];
        foreach (OrganizerAccountStatus::cases() as $status) {
            $results[] = [
                'value' => $status->value,
                'description' => $status->label(),
                'count' => $counts[$status->value] ?? 0
            ];
        }
        
        return response()->json($results);
    }

    public function getAccountRoleStats()
    {
        $counts = User::selectRaw('role, count(*) as count')
            ->where('role', '!=', UserRole::GUEST->value)
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();
        
        $results = [];
        foreach (UserRole::cases() as $status) {
            if ($status === UserRole::GUEST) {
                continue;
            }
            
            $results[] = [
                'value' => $status->value,
                'description' => $status->permissionLabel(),
                'count' => $counts[$status->value] ?? 0
            ];
        }
        
        return response()->json($results);
    }
    private function getPageData(Request $request): array
    {
        $usersPaginator = $this->getFilteredUsers($request);
        $organizerStats = $this->getAccountStatusStats();
        $userStats = $this->getAccountRoleStats();

        return [
            'users' => UserAdminBrowserResource::collection($usersPaginator)
                        ->response()
                        ->getData(true),
            
            'organizer_stats' => $organizerStats,
            'user_stats' => $userStats
        ];
    }

    public function changeStatus(Request $request, $id)
    {
        $validRoles = array_filter(
            array_column(UserRole::cases(), 'value'),
            fn($role) => $role !== UserRole::ORGANIZER->value
        );

        $validated = $request->validate([
            'account_status' => ['required', 'string', Rule::in($validRoles)],
        ]);
    
        $user = User::findOrFail($id);
        $newRole = UserRole::from($validated['account_status']);

        if ($user->role === UserRole::ORGANIZER->value) {
            return redirect()->back()
                ->withErrors(['account_status' => 'Nie można zmienić roli organizatora, proszę zmienić status konta organizatora'])
                ->withInput();
        }
        
        if ($user->role === UserRole::ADMIN->value) {
            return redirect()->back()
                ->withErrors(['account_status' => 'Nie można zmienić roli konta administratorskiego'])
                ->withInput();
        }

        if($newRole === UserRole::ORGANIZER) {
            return redirect()->back()
                ->withErrors(['account_status' => 'Nie można zmienić roli na organizatora, proszę założyć konto organizatorskie'])
                ->withInput();
        }
        
        if($newRole === UserRole::ADMIN) {
            return redirect()->back()
                ->withErrors(['account_status' => 'Nie można zmienić roli na Administratora, proszę założyć konto administratorskie'])
                ->withInput();
        }


        $user->role = $newRole->value;
        $user->permission_level = $newRole->permissionLevel();

        if ($newRole === UserRole::UNVERIFIED_USER) {
            $user->email_verified_at = null;
            $user->save();        
            Mail::to($user->email)->send(new VerifyEmail($user));
        } elseif ($newRole === UserRole::VERIFIED_USER && is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        } else {
            $user->save();
        }

        $usersPaginator = $this->getFilteredUsers($request);      

        return redirect()->back()->with([
            'users' => UserAdminBrowserResource::collection($usersPaginator)
                                                ->response()
                                                ->getData(true),
            ]);
    }
}
