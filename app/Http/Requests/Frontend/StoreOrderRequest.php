<?php

namespace App\Http\Requests\Frontend;

use App\ErrorMessages;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'item'      => ['required'],
            'sub_total' => ['required'],
            'shift_id'  => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'item.required'      => ErrorMessages::REQUIRE_MESSAGE . 'Items.',
            'sub_total.required' => ErrorMessages::REQUIRE_MESSAGE . 'Sub Total.',
            'shift_id.required'  => ErrorMessages::REQUIRE_MESSAGE . 'Required Shift Id.',
        ];
    }
}