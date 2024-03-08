<?php

namespace App\Http\Requests;

use App\Rules\ShiftValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingDelRequest extends FormRequest
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
            'id'   => ['required','numeric',new ShiftValidationRule()],
        ];
    }


    public function messages()
    {
        return [
            'id.required'              => 'Setting id is required',
            'id.numeric'               => 'Setting id must be numeric',
        ];
    }
}
