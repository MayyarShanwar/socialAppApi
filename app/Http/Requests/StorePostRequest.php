<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:5|max:15|string',
            'content' => 'required|min:10|string'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => "Please enter a title, it is mandatory  "
        ];
    }
}
