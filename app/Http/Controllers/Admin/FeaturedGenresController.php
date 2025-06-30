<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FeaturedGenresRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use inertia\Inertia;

class FeaturedGenresController extends Controller
{
public function update(Request $request)
{
    DB::beginTransaction();
    try {
        $featuredGenres = $request->input('featured_genres', []);
        $files = $request->file('featured_genres', []);
        $results = [];
        $successCount = 0;
        $slotIds = [1, 2, 3, 4, 5];

        foreach ($slotIds as $slotIndex => $slotId) {
            try {
                $data = $featuredGenres[$slotIndex] ?? null;
                if (!$data) {
                    Log::debug("No data for slot $slotId at index $slotIndex");
                    continue;
                }

                $record = FeaturedGenre::find($slotId);
                if (!$record) {
                    Log::error("Featured genre slot $slotId not found in database");
                    continue;
                }

                $record->genre_id = $data['id'] ?? 0;

                if (isset($files[$slotIndex]['file'])) {
                    $file = $files[$slotIndex]['file'];
                    if ($file->isValid()) {
                        // if ($record->image_path) {
                        //     Storage::disk('public')->delete($record->image_path);
                        // }

                        $filename = 'category_'.$slotId.'_'.time().'.'.$file->getClientOriginalExtension();
                        $record->image_path = $file->storeAs('featured_categories', $filename, 'public');
                    }
                }

                $record->save();
                $results[] = [
                    'slot_id' => $slotId,
                    'genre_id' => $record->genre_id,
                    'image_url' => $record->image_path ? Storage::url($record->image_path) : null
                ];
                $successCount++;

            } catch (\Exception $e) {
                Log::error("Error updating slot $slotId: ".$e->getMessage());
                continue;
            }
        }

        DB::commit();
        $featuredCategories = FeaturedGenre::all();

            return response()->json([
                  'message' => 'Zaktualizowano promowane kategorie',
                  'updated_count' => count($results),
                  'featured_categories' => $featuredCategories
            ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'error' => 'Update failed: '.$e->getMessage()
        ], 500);
    }
}
}
