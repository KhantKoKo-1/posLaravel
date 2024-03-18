<?php

namespace App\Http\Requests;

use App\ErrorMessages;
use App\Rules\ShiftValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ItemDelRequest extends FormRequest
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
            'id' => ['required','numeric',new ShiftValidationRule],
        ];
    }

    public function messages()
    {
        return [
            'id.required' => ErrorMessages::REQUIRE_MESSAGE . 'Category Id',
            'id.numeric'  => 'Category Id' . ErrorMessages::NUMERIC_MESSAGE,
        ];
    }
}