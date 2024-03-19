<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingUpdRequest extends FormRequest
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
                                        ->whereNull('deleted_at')
                                        ->ignore(request('id')),
                                ],
            'company_phone'   => 'required',
            'company_email'   => 'required|email',
            'company_address' => 'required',
            'upload_photo'    => ['required_if:has_image,1', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages()
    {
        return [
            'company_name.required'    => 'Please fill company name .',
            'company_name.unique'      => 'Company name is already exists .',
            'company_phone.required'   => 'Please fill company phone .',
            'company_email.required'   => 'Please fill company email .',
            'company_email.email'      => 'Wrong email format .',
            'company_address.required' => 'Please fill company cddress .',
            'upload_photo.required_if' => 'Please upload photo.',
            'upload_photo.mimes'       => 'Please fill valid photo type.',
        ];
    }
}
