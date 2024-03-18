<?php

namespace App\Http\Requests;

use App\ErrorMessages;
use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'username' => ['required'],
            'password' => ['required','min:6'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => ErrorMessages::REQUIRE_MESSAGE . 'Username.',
            'password.required' => ErrorMessages::REQUIRE_MESSAGE . 'Password.',
            'password.min'      => 'Password' . ErrorMessages::PASSWORD_MIN_MESSAGE,
        ];
    }
}