<?php
 
namespace App\Http\Controllers\Static;
 
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class TermsOfUseController extends Controller
{
    public function index()
    {
        return Inertia::render('TermsOfUse')->with('title', 'Warunki Użytkowania');
    }
}