<?php

namespace App\Http\Requests;

use App\Constant;
use App\ErrorMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountStoreRequest extends FormRequest
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
        $account_type = $this->account_type;
        $rules = [
            'username'          => [
                                    'required',
                                    Rule::unique('users', 'username')
                                        ->where(function ($query) use ($account_type) {
                                            if ($account_type === 'admin') {
                                                $query->where('role', Constant::ADMIN_ROLE);
                                            } else {
                                                $query->where('role', Constant::CASHIER_ROLE); 
                                            }
                                            $query->whereNull('deleted_at');
                                        }),
                                        $account_type !== 'admin' ? 'numeric' : '',
                                ],
            'password'          => ['required', 'min:6', $account_type !== 'admin' ? 'numeric' : ''],
            'confirm_password'  => ['required', 'min:6', 'same:password', $account_type !== 'admin' ? 'numeric' : ''],
        ];
        return $rules;
    }

    public function messages()
    {
        if($this->account_type == 'cashier') {
            $name = 'Cashier Id.';
        } else {
            $name = 'Username.';
        }
        return [
            'username.required'         => ErrorMessages::REQUIRE_MESSAGE . $name,
            'username.unique'           => 'Username' . ErrorMessages::UNIQUE_MESSAGE,
            'username.numeric'          => 'Username' . ErrorMessages::NUMERIC_MESSAGE,
            'password.required'         => ErrorMessages::REQUIRE_MESSAGE . 'Password.',
            'password.numeric'          => 'Password' . ErrorMessages::NUMERIC_MESSAGE,
            'password.min'              => 'Password' . ErrorMessages::PASSWORD_MIN_MESSAGE,
            'confirm_password.required' => ErrorMessages::REQUIRE_MESSAGE . 'Confirm Password.',
            'confirm_password.numeric'  => 'confirm_password' . ErrorMessages::NUMERIC_MESSAGE,
            'confirm_password.min'      => 'Confirm password' . ErrorMessages::PASSWORD_MIN_MESSAGE,
            'confirm_password.same'     => 'The Password And Confirm Password' . ErrorMessages::SAME_MESSAGE,
        ];
    }
}