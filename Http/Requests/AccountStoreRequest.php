<?php

namespace App\Http\Requests;

use App\Constant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountStoreRequest extends FormRequest
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
        $account_type = $this->account_type;
        $rules = [
            'username' => [
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
            'password' => ['required', 'min:6', $account_type !== 'admin' ? 'numeric' : ''],
            'confirm_password' => ['required', 'min:6', 'same:password', $account_type !== 'admin' ? 'numeric' : ''],
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'username.required'         => 'Please fill user name .',
            'username.unique'           => 'UserName is already exists .',
            'username.numeric'          => 'UserName must be numeric .',
            'password.required'         => 'Please fill password .',
            'password.numeric'          => 'password must be numeric .',
            'password.min'              => 'Password must be at least 6 character.',
            'confirm_password.required' => 'Please fill confirm password .',
            'confirm_password.numeric'  => 'confirm_password must be numeric .',
            'confirm_password.min'      => 'Confirm password must be at least 6 character.',
            'confirm_password.same'     => 'The password and confirm password must be same.',
        ];
    }
}