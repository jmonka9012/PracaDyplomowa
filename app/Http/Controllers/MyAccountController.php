<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\MyAccountDataChangeRequest;
use Illuminate\Support\Facades\Hash;


class MyAccountController extends Controller
{
    public function index()
    {
        return Inertia::render('My-Account');
    }

    public function store(MyAccountDataChangeRequest $request)
    {
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

        if (!empty($updateData)) {
            $request->user()->update($updateData);
            return back()->with('success','Profil zauktalizowany');
        }

        return back()->with('error','błąd');
    }
}