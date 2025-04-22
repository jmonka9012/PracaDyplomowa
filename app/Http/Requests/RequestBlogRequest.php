<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestBlogRequest extends FormRequest
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
            'post_name' => 'required|string|max:255|unique:blog_posts,blog_post_name',
            'post_content' => 'required|max:65535',
            'post_image' => [
                'required',
                'image',
                'max:10240',
                'dimensions:min_width=800, min_height=600'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'required'=> 'To pole jest wymagane',
        ];
    }
}
