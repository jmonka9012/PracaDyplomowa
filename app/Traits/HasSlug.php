<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function($model){
            $model->generateSlug();
            $model->generateUrl();
        });

        static::updating(function($model) {
            if ($model->isDirty($model->getSlugFromColumn())) {
                $model->generateSlug();
                $model->generateUrl();
            }
        });
    } 

    protected function generateSlug()
    {
        $source = $this->{$this->getSlugFromColumn()};
        $slug = Str::slug($source);

        $originalSlug = $slug;
        $count = 1;

        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $count++;
        }

        $this->slug = $slug;
    }

    protected function slugExists($slug)
    {
        $query = static::where('slug', $slug);

        if ($this->exists){
            $query->where('id', '!=', $this->id);
        }
        return $query->exists();
    }

    protected function getSlugFromColumn()
    {
        return match(get_class($this)){
            'App\Models\Blog\BlogPost' => 'blog_post_name',
            default => 'event_name',
        };
    }

    protected function generateUrl()
    {
        if (get_class($this) === 'App\Models\Blog\BlogPost') {
            return;
        }

        // Format date as YYYY-MM-DD
        $datePart = Carbon::parse($this->event_date)->format('Y-m-d');
        
        // Slugify the location if needed
        $locationPart = $this->event_location;
        
        $this->event_url = sprintf('wydarzenia/%s/%s/%s',
            $datePart,
            $locationPart,
            $this->slug
        );
    }
}
