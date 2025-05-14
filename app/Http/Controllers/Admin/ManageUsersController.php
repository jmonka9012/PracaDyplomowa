<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\UserAdminBrowserResource;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.users', ['page' => 1] + $request->except('page'));
        }

        $users = $this->getFilteredUsers($request);

        return Inertia::render('Admin/ManageUsers',[
            'users' => UserAdminBrowserResource::collection($users)->response()->getData(true),
        ]);
    }

    public function showData(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.users.data', ['page' => 1] + $request->except('page'));
        }

        $users = $this->getFilteredUsers($request);

        return response()->json([
            'users' => UserAdminBrowserResource::collection($users)->response()->getData(true),
        ]);
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
                    ->appends($request->query());
    }
}
