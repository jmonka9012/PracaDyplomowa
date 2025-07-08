<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\AdminOrderResource;
use App\Http\Resources\SupportTicketResource;
use App\Models\Events\Order;
use App\Models\EventSeats\EventSeat;
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

        $orders = [];

        if ($request->has('order_lookup')) {
            $orders = $this->getOrders($request);
        }

        return Inertia::render('Admin/CustomerService', [
            'support_tickets' =>SupportTicketResource::collection($tickets)->response()->getData(true),
            'orders' => $orders
        ]);
    }

    public function showData(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.customer-service.data', ['page' => 1] + $request->except('page'));
        }

        $query = $this->getTickets($request);

        $orders = [];
        $tickets = $query->paginate(10);

        if ($request->has('order_lookup')) {
            $orders = $this->getOrders($request);
        }

        return response()->json([
            'support_tickets' =>SupportTicketResource::collection($tickets)->response()->getData(true),
            'orders' => $orders
        ]);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:in_progress,closed',
            'id' => 'required|exists:support_tickets,id'
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $ticket->status = $request->input('status');
        $ticket->save();

    }

public function getOrders(Request $request)
{
    $search = $request->input('order_lookup');
    
    $query = Order::with([
        'event',
        'tickets',
        'tickets.seat',
        'tickets.standingTicket',
        'tickets.seat.section',
        'tickets.standingTicket.section'
    ]);


    if (str_starts_with($search, 'ORD-')) {
        $query->where('order_number', $search);
    }
    
    else {
        $query->where(function($q) use ($search) {
            $q->where('order_number', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%");
        });
    }

    $orders = $query->get();

    return AdminOrderResource::collection($orders);
}
}
