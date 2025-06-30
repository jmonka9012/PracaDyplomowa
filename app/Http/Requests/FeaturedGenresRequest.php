<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeaturedGenresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

public function rules()
    {
        return [
            'featured_categories' => 'required|array|min:1|max:5',
            'featured_categories.*' => 'required|array',
            'featured_categories.*.file' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'featured_categories.*.genre_id' => [
                'required',
                Rule::exists('genres', 'id')
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'To pole jest wymagane',

            'featured_categories.required' => 'Wymagana jest przynajmniej jedna promowana kategoria',
            'featured_categories.min' => 'Wymagana jest przynajmniej jedna promowana kategoria',
            'featured_categories.max' => 'Maksymalna ilość promowanych kategorii to 5',
            
            'featured_categories.*.file.required' => 'Każda kategoria potrzebuje zdjęcie',
            'featured_categories.*.file.image' => 'The file must be an image',
            'featured_categories.*.file.mimes' => 'Zezwolone formaty zdjecia to JPEG, PNG i JPG',
            'featured_categories.*.file.max' => 'Maksymalna wielkość zdjęcia to 2MB',
            
            'featured_categories.*.genre_id.required' => 'Każda kategoria promowana wymaga wybrania kategorii',
            'featured_categories.*.genre_id.exists' => 'Wybrana kategoria nie istnieje',
        ];
    }
}
