<?php

namespace App\Http\Controllers;

use App\Models\OrganizerInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ManageOrganizerController extends Controller
{
    public function changeStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'account_status' => 'required|string|in:verified,denied,pending',
        ]);
    
        $organizer = OrganizerInformation::findOrFail($id);
        $organizer->account_status = $request->input($validated['account_status']);
        $organizer->save();
        
        return response()->json([
        'message' => 'Status konta organizatorskiego zmieniony.',
        'data' => $organizer
    ]);
    }
}
