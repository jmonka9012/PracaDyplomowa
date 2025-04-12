<?php

namespace App\Traits;

use Illuminate\Support\Str;
trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function($model){
            $model->generateSlug();
        });

        static::updating(function($model) {
            if ($model->isDirty($model->getSlugFromColumn())) {
                $model->generateSlug();
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
        return 'event_name';
    }
}
