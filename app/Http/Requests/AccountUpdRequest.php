<?php

namespace App\Http\Requests;

use App\Constant;
use App\ErrorMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountUpdRequest extends FormRequest
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
        $rules = [];
        if(request('editType') == 'company_info'){
            $rules['username'] = [
                'required',
                Rule::unique('users', 'username')
                    ->where(function ($query) use ($account_type) {
                        if ($account_type === 'admin') {
                            $query->where('role', Constant::ADMIN_ROLE);
                        } else {
                            $query->where('role', Constant::CASHIER_ROLE); 
                        }
                        $query->whereNull('deleted_at');
                    })->ignore(request('id')),
                    $account_type !== 'admin' ? 'numeric' : '',
            ];
            return $rules;
        }

        if(request('editType') == 'password'){ 
            $rules['old_password'] = [
                'required',
                function ($attribute, $value, $fail) {
                    $userId = request('id');
                    $userPassword = DB::table('users')->where('id', $userId)->value('password');

                    if (!Hash::check($value, $userPassword)) {
                        $fail('The '.$attribute.' is incorrect.');
                    }
                },
                $account_type !== 'admin' ? 'numeric' : '',
            ];
            $rules['password'] = ['required', 'min:6', $account_type !== 'admin' ? 'numeric' : ''];
            $rules['confirm_password'] = ['required', 'min:6', 'same:password', $account_type !== 'admin' ? 'numeric' : ''];
            return $rules;
        }
    }

    public function messages()
    {
        return [
            'username.required'         => ErrorMessages::REQUIRE_MESSAGE . 'Username.',
            'username.unique'           => 'Username' . ErrorMessages::UNIQUE_MESSAGE,
            'username.numeric'          => 'Username'. ErrorMessages::NUMERIC_MESSAGE,
            'password.required'         => ErrorMessages::REQUIRE_MESSAGE . 'password .',
            'password.numeric'          => 'Password' . ErrorMessages::NUMERIC_MESSAGE,
            'password.min'              => 'Password' . ErrorMessages::PASSWORD_MIN_MESSAGE,
            'confirm_password.required' => ErrorMessages::REQUIRE_MESSAGE . 'Confirm Password.',
            'confirm_password.numeric'  => 'Confirm Password' . ErrorMessages::NUMERIC_MESSAGE,
            'confirm_password.min'      => 'Confirm password' . ErrorMessages::PASSWORD_MIN_MESSAGE,
            'confirm_password.same'     => 'The Password and Confirm password' . ErrorMessages::SAME_MESSAGE,
        ];
    }
}