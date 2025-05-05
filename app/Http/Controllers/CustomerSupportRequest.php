<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;
use App\Http\Requests\SupportTicketRequest;
use Illuminate\Support\Facades\Auth;

class CustomerSupportRequest extends Controller
{
    public function store(SupportTicketRequest $request)
    {
        $ticket = SupportTicket::create($request->validated());
    
        return back()->with('success', true);
    }
}
