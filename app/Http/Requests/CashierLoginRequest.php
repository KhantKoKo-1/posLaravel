<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class CashierLoginRequest extends BaseFormRequest
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
            'username' => ['required', 'numeric'],
            'password' => ['required', 'min:6','numeric' ],
        ];
    }

    protected $attributeName = 'username';
}
