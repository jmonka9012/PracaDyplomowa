<?php
 
namespace App\Http\Controllers\Static;
 
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class FAQController extends Controller
{
    public function index()
    {
        return Inertia::render('FAQ')->with('title', 'Często Zadawane Pytania');
    }
}