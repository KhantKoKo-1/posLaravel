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
            'password' => ['required', 'min:6','numeric' ],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Please fill username .',
            'username.numeric'  => 'Username must be numeric .',
            'password.required' => 'Please fill password .',
            'password.min'      => 'The password must be at least 6 digits.',
            'password.numeric'  => 'Password must be numeric .',

        ];
    }
}
