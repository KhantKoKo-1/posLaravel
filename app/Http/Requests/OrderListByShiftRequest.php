<?php

namespace App\Http\Requests;

use App\Rules\ShiftValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderListByShiftRequest extends FormRequest
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
            'shift_id'   => ['required'],
        ];
    }


    public function messages()
    {
        return [
            'shift_id.required'              => 'Shift id is required',
            'shift_id.numeric'               => 'Shift id must be numeric',
        ];
    }
}
