<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\SupportTicketResource;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;

class CustomerServiceController extends Controller
{
    private function getTickets(Request $request)
    {
        $query = SupportTicket::orderByRaw("status = 'in_progress' DESC")
            ->orderBy('created_at', 'desc');
    

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

    return $query;
    }
    
    public function show(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.customer-service', ['page' => 1] + $request->except('page'));
        }

        $query = $this->getTickets($request);

        $tickets = $query->paginate(10)
            ->appends($request->query());

        return Inertia::render('Admin/CustomerService', [
            'tickets' =>SupportTicketResource::collection($tickets)->response()->getData(true),
        ]);
    }

    public function showData(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.customer-service.data', ['page' => 1] + $request->except('page'));
        }
        
        $query = $this->getTickets($request);

        $tickets = $query->paginate(10);

        return response()->json([
            'tickets' =>SupportTicketResource::collection($tickets)->response()->getData(true),
        ]);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:in_progress,solved',
            'id' => 'required|exists:support_tickets,id'
        ]);
    
        $ticket = SupportTicket::findOrFail($id);
        $ticket->status = $request->input('status');
        $ticket->save();
    
    }
}
