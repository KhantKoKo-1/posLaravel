<?php

namespace App\Http\Requests;

use App\Constant;
use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;

class AccountStoreRequest extends BaseFormRequest
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

    protected $attributeName = 'username';
}
