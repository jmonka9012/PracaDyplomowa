<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizerDetailsRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'company_nip' => 'required|string|max:20',
            'bank_account' => 'required|string|max:34',
            'company_country' => 'required|string|max:100',
            'company_city' => 'required|string|max:100',
            'company_zip_code' => 'required|string|max:20',
            'company_street' => 'required|string|max:255',       
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'To pole jest wymagane',
        ];
    }
}
