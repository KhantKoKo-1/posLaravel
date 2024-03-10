<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'username' => ['required'],
            'password' => ['required','min:6'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username and password cannot be null .',
            'password.required' => 'Please fill password .',
            'password.min'      => 'Password must be at least 6 charater .',
        ];
    }
}
