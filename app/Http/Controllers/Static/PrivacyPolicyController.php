<?php
 
namespace App\Http\Controllers\Static;
 
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        return Inertia::render('PrivacyPolicy');
    }
}