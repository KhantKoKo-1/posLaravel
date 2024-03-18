<?php

namespace App\Http\Requests;

use App\ErrorMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingStoreRequest extends FormRequest
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

    public function messages()
    {
        return [
            'company_name.required'    => ErrorMessages::REQUIRE_MESSAGE . 'Company Name.',
            'company_name.unique'      => 'Company Name' . ErrorMessages::UNIQUE_MESSAGE,
            'company_phone.required'   => ErrorMessages::REQUIRE_MESSAGE . 'Company Phone.',
            'company_email.required'   => ErrorMessages::REQUIRE_MESSAGE . 'Company Email.',
            'company_email.email'      => ErrorMessages::WRONG_FORMAT_MESSAGE . 'Email.',
            'company_address.required' => ErrorMessages::REQUIRE_MESSAGE . 'Company Address.',
            'upload_photo.required'    => ErrorMessages::IMAGE_REQUIRE_MESSAGE,
            'upload_photo.mimes'       => ErrorMessages::INVALID_IMAGE_MESSAGE,
        ];
    }
}