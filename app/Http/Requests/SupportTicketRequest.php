<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportTicketRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'topic' => 'required|string|max:255',
            'message' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
    public function messages(): array
    {
        return [
            'sometimes' => 'To pole jest wymagane'
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->user()) {
            $this->merge([
                'email' => $this->user()->email,
                'name' => $this->user()->first_name . ' ' . $this->user()->last_name,
                'user_id' => $this->user()->id,
            ]);
        }
    }

}
