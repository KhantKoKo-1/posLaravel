<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class GetCategoryRequest extends FormRequest
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
            'parent_id' => ['required','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => 'Required Parent Id .',
            'parent_id.numeric'  => 'Parent Id Must Be Numeric.',
        ];
    }
}