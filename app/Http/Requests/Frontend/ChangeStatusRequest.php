<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusRequest extends FormRequest
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
            'order_id' => ['required'],
            'status'   => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Required order id .',
            'status.required'   => 'Required Status .',
        ];
    }
}