<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\AdminPanelOrgarnizerData;
use App\Http\Resources\UserAdminBrowserResource;
use App\Models\OrganizerInformation;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function index(Request $request)
    {
        $defaults = [
        'page' => 1,
        'pending_page' => 1,
        'denied_page' => 1,
        ];
        
        $missing = collect($defaults)->filter(function ($_, $key) use ($request) {
        return ! $request->has($key);
        });

        if ($missing->isNotEmpty()) {
            return redirect()->route('admin.users', array_merge(
                $request->query(),
                $missing->all()
            ));
        }
        
        return Inertia::render('Admin/ManageUsers', $this->getPageData($request));
    }

    public function showData(Request $request)
    {
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

            return Inertia::location($request->headers->get('referer'));
            
        } catch (\Exception $e){
            DB::rollBack();

            return response()->json([
                'user_deleted' => false,
                'message' => 'Użytkownik nie został usunięty',
            ]);
        }
    }
    
    protected function getFilteredUsers(Request $request)
    {
        $query = User::withTicketCounts();
    
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
    
        return $query->paginate(20)
                    ->appends($request->except('page'));
    }

    public function getPendingOrganizersData(Request $request)
    {
        $organizersPending = OrganizerInformation::where('account_status', 'verified')->get();
        $organizersDenied = OrganizerInformation::where('account_status', 'denied')->get();

        return response()->json([
            'organizers_pending' => AdminPanelOrgarnizerData::collection($organizersPending),
            'organizers_denied' => AdminPanelOrgarnizerData::collection($organizersDenied)
        ]);
    }

    protected function getOrganizersByStatus(Request $request, string $status, string $pageName)
    {
        return OrganizerInformation::where('account_status', $status)
            ->paginate(20, ['*'], $pageName)
            ->appends($request->except($pageName));
    }

    private function getPageData(Request $request): array
    {
        $usersPaginator = $this->getFilteredUsers($request);

        $pendingPaginator = $this->getOrganizersByStatus(
            $request,
            'pending',
            'pending_page'
        );

        $deniedPaginator = $this->getOrganizersByStatus(
            $request,
            'denied',
            'denied_page'
        );

        return [
            'users' => UserAdminBrowserResource::collection($usersPaginator)
                        ->response()
                        ->getData(true),

            'organizers' => [
                'pending' => AdminPanelOrgarnizerData::collection($pendingPaginator)
                                ->response()
                                ->getData(true),

                'denied'  => AdminPanelOrgarnizerData::collection($deniedPaginator)
                                ->response()
                                ->getData(true),
            ],
        ];
    }
}
