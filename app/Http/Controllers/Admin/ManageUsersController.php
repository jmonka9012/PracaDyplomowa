<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserDataResource;


class ManageUsersController extends Controller
{
    public function index()
    {
        $users = User::all();

        return Inertia::render('Admin/ManageUsers',[
            'users' => UserDataResource::collection($users)
        ]);
    }

    public function showData()
    {
        $users = User::all();

        return response()->json([
            'users' => UserDataResource::collection($users)
        ]);
    }
}
