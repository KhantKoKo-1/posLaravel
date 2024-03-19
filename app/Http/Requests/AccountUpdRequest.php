<?php

namespace App\Http\Requests;

use App\Constant;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\BaseFormRequest;


class AccountUpdRequest extends BaseFormRequest
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

    protected $attributeName = 'username';
}
