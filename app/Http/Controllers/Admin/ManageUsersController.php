<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserDataResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);

        return Inertia::render('Admin/ManageUsers',[
            'users' => UserDataResource::collection($users)->response()->getData(true),
        ]);
    }

    public function showData()
    {
        $users = User::paginate(20);

        return response()->json([
            'users' => UserDataResource::collection($users)->response()->getData(true),
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
}
