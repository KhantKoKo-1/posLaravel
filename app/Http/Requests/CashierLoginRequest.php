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
            'username' => ['required','numeric'],
            'password' => ['required', 'min:6'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Please fill username .',
            'username.numeric'  => 'User name must be numeric .',
            'password.required' => 'Please fill password .',
            // 'password.numeric'  => 'Password must be numeric .',
            'password.min'      => 'The password must be at least 6 characters long."',
        ];
    }
}
