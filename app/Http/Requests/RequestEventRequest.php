<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEventRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'event_name' => 'required|string|max:255|unique:events,event_name|unique:events_archive,event_name',
            'event_additional_url' => 'string|max:255|unique:events,event_additional_url',
            'event_date' => 'required|date|after:+'.now()->addDays(6),
            'event_start' => 'required',
            'event_end' => 'required',
            'contact_email' => 'email|max:255',
            'contact_email_additional' => 'email|max:255',
            'event_description' => 'required|max:65535',
            'event_description_additional' => 'required|max:65535',
            'event_location' => 'string|max:255',
            'image_path' => 'string|max:255|nullable',
            'genre' => 'required|integer|exists:genres,id',
            'section_prices' => 'required|array',
            'section_prices.*' => 'nullable|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'required'=> 'To pole jest wymagane',
            'event_name.unique' => 'Istnieję już wydarzenia z tą nazwą',
            'event_name.max' => 'Nazwa wydarzenia jest zbyt długa',
            'event_additional_url.unique' => 'Istnieje już wydarzenia z tym URLem',
            'event_additional_url.max'=> 'URL wydarzenia jest zbyt długie',
            'email'=> 'Adres email jest wymagany',
            'event_description.max' => 'Opis jest zbyt długi',
            'event_description_additional.max'=> 'Dodtakowe informacje są zbyt długie',
            'event_description.required'=> 'Brak opisu',
            'event_date.after'=> 'Potrzebujemy przynajmniej tygodnia na organizacje wydarzenia, wybierz datę przynajmniej tydzień w przód',
            'genre.exists' => 'Kategoria nie istniej',
            'section_prices.*.min' => 'Cena musi być ustawiona powyżej 0'
        ];
    }
}
