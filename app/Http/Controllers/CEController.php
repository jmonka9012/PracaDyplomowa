<?php

namespace App\Http\Controllers;
use App\Models\Hall;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CEController extends Controller
{
    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        if ($routeName === 'jacek') {
            return Inertia::render('Events/EventForm');
        } else if ($routeName === 'ce') {
            return Inertia::render('CE');
        }
    }

    public function getTest1(Request $request){
         return [
        'test' => "1 to numer"
    ]; 
    }

    public function getTest2(Request $request){
         return [
        'test' => "8 to nieskończoność jeśli ją obrócisz"
    ]; 
    }
}
