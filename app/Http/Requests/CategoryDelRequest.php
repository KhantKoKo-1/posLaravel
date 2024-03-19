<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Rules\ShiftValidationRule;
use App\Http\Requests\BaseFormRequest;

class CategoryDelRequest extends BaseFormRequest
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
            'id'   => ['required','numeric',new ShiftValidationRule()],
        ];
    }

    protected $attributeName = 'category';
}
