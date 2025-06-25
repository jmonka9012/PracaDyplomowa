<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedCategory;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FeaturedCategoriesRequest;
class FeaturedCategoriesController extends Controller
{
      // app/Http/Controllers/FeaturedCategoryController.php

// app/Http/Controllers/FeaturedCategoryController.php

      public function update(FeaturedCategoriesRequest $request)
      {
            $results = [];
            
            foreach ($request->featured_categories as $index => $data) {
                  $filename = 'category_' . ($index + 1) . '_' . time() . '.' . $data['file']->extension();
                  
                  $path = $data['file']->storeAs(
                        'featured_categories',
                        $filename,
                        'public'
                  );

                  $featuredCategory = FeaturedCategory::updateOrCreate(
                        ['id' => $index + 1],
                        [
                        'genre_id' => $data['genre_id'],
                        'image_path' => $path
                        ]
                  );

                  $results[] = [
                        'id' => $featuredCategory->id,
                        'genre_id' => $featuredCategory->genre_id,
                        'image_url' => Storage::url($path)
                  ];
            }

            return redirect()->back()->with([
                  'message' => 'Zaktualizowano promowane kategorie',
                  'updated_count' => count($results),
                  'updated_categories' => $results
            ]);
      }
}
