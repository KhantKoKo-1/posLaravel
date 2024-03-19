<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;

class SettingUpdRequest extends BaseFormRequest
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
    protected $attributeName = 'setting';
}
