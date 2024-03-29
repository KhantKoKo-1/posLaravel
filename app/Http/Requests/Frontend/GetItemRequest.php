<?php

namespace App\Http\Requests\frontend;

use Illuminate\Foundation\Http\FormRequest;

class GetItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => ['required','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Required Category Id .',
            'category_id.numeric'  => 'Category Id Must Be Numeric.',
        ];
    }
}