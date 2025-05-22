<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrganizerInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Resources\UserAdminBrowserResource;

class ManageOrganizerController extends Controller
{
    public function changeStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'account_status' => 'required|string|in:verified,denied,pending',
        ]);
    
        $organizer = OrganizerInformation::findOrFail($id);
        $organizer->account_status = $validated['account_status'];
        $organizer->save();

        $manageUsersController = new ManageUsersController();
        $usersPaginator = $manageUsersController->getFilteredUsers($request);
        

        return redirect()->route('admin.users')->with([
            'users' => UserAdminBrowserResource::collection($usersPaginator)
                                                    ->response()
                                                    ->getData(true),
            ]);
    }
}
