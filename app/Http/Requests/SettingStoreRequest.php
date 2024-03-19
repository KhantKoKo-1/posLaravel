<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;

class SettingStoreRequest extends BaseFormRequest
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
            'company_name'    => [
                                    'required',
                                    Rule::unique('setting', 'company_name')
                                        ->where(function ($query) {
                                            $query->whereNull('deleted_at');
                                        }),
                                ],
            'company_phone'   => 'required',
            'company_email'   => 'required|email',
            'company_address' => 'required',
            'upload_photo'    => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    protected $attributeName = 'setting';
}
