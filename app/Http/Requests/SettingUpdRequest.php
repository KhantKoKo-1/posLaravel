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
            'company_name' => [
                'required',
                Rule::unique('setting', 'company_name')
                    ->whereNull('deleted_at')
                    ->ignore(request('id')),
            ],
            'company_phone' => 'required',
            'company_email' => 'required|email',
            'company_address' => 'required',
            'upload_photo' => ['required_if:has_image,1', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'Please Fill Company Name .',
            'company_name.unique' => 'Company name is already exists .',
            'company_phone.required' => 'Please Fill Company Phone .',
            'company_email.required' => 'Please Fill Company Email .',
            'company_email.email' => 'Wrong Format Email .',
            'company_address.required' => 'Please Fill Company Address .',
            'upload_photo.required_if' => 'Please upload photo.',
            'upload_photo.mimes' => 'Please fill valid photo type.',
        ];
    }
}