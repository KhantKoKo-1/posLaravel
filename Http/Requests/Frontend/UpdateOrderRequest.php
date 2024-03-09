<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'item'      => ['required'],
            'sub_total' => ['required'],
            'shift_id'  => ['required'],
            'order_id'  => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'item.required'      => 'Required Items .',
            'sub_total.required' => 'Required Sub Total .',
            'shift_id.required'  => 'Required Shift Id .',
            'order_id.required'  => 'Required Order Id .',
        ];
    }
}
