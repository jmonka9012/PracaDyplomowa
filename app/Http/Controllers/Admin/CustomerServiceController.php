<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;


class CustomerServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/CustomerService');
    }
}
