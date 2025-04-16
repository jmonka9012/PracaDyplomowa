<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ImageUploadController extends Controller
{
    public function storeImages(Request $request)
    {
        $request->validate([
           'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]); 

        if ($request->route()->named('event-create.image')){
            $wysywigPath = 'wysywig-events';
        }

        $image = $request->file('image');
        $path = $image->storeAs(
            $wysywigPath . '/' . date('Y') . '/' . date('m'),
            time().'_'.$image->getClientOriginalName(),
            'public'
        );

        return response()->json([
            'location' => asset(Storage::url($path))
        ]);
    }
}
