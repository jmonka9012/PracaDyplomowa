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
}
