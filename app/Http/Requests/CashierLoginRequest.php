<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashierLoginRequest extends FormRequest
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
            'username' => ['required', 'numeric'],
            'password' => ['required', 'numeric', 'digits:6' ],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Please fill username .',
            'username.numeric'  => 'Username must be numeric .',
            'password.required' => 'Please fill password .',
            'password.numeric'  => 'Password must be numeric .',
            'password.digits'   => 'The password must be exactly 6 digits.',
        ];
    }
}
