<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
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
            'item_id' => ['required','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'item_id.required' => 'Required Item Id .',
            'item_id.numeric'  => 'Item Id Must Be Numeric.',
        ];
    }
}