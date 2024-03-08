<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class FetchOrderDetailRequest extends FormRequest
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
            'order_id'  => ['required'],
            'shift_id'  => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Required Order Id .',
            'shift_id.required' => 'Required Shift Id .',
        ];
    }
}
