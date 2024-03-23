<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    /**
     * Placeholder for attribute name in validation messages.
     *
     * @var string
     */
    protected $attributeName = ':attribute';

    /**
     * Get the validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'             => 'Please fill ' . $this->attributeName . ' name.',
            'name.unique'               => 'The ' . $this->attributeName . ' name already exists.',
            'parent_id.required'        => 'Please select parent category.',
            'upload_photo.required'     => 'Please upload ' . $this->attributeName . ' image.',
            'upload_photo.mimes'        => 'Please upload valid image type.',
            'upload_photo.required_if'  => 'Please upload photo.',

            'category_id.required'      => 'Please select parent category.',
            'price.required'            => 'Please fill '. $this->attributeName .' price.',
            'quantity.required'         => 'Please fill '. $this->attributeName .' quantity.',

            'discount_type.required'    => 'Please choose ' . $this->attributeName . ' type.',
            'amount.required'           => 'Please fill ' . $this->attributeName . ' amount.',
            'amount.numeric'            => 'The ' . $this->attributeName . ' amount must be numeric.',
            'amount.max'                => 'The ' . $this->attributeName . ' percentage must be between 0 and 100%.',
            'start_date.required'       => 'Please fill ' . $this->attributeName . ' start date.',
            'start_date.date'           => 'Please fill valid ' . $this->attributeName . ' date format.',
            'end_date.required'         => 'Please fill ' . $this->attributeName . ' end date.',
            'end_date.date'             => 'Please fill valid ' . $this->attributeName . ' date format.',
            'end_date.after'            => 'End date is greater than start date.',
            'item.required'             => 'Please choose discount item.',

            'username.required'         => 'Please fill '. $this->attributeName .'.',
            'role.required'             => 'Please select role',
            'image.required'            => 'Please select image',
            'image.mimes'               => 'Please select valid image extention',

            'newPassword.required'      => 'Please fill password.',
            'confirmPassword.required'  => 'Please fill confim password.' ,
            'confirmPassword.same'      => 'New password and confirm password did not match.',

            'id.required'               => 'The ' . $this->attributeName .' id is required.',
            'id.numeric'                => 'The ' . $this->attributeName .' id must be numeric.',

            'shift_id.required'         => $this->attributeName .' id is required',
            'shift_id.numeric'          => $this->attributeName .' id must be numeric',

            'company_name.required'     => 'Please fill '. $this->attributeName .' name.',
            'company_name.unique'       => 'The'. $this->attributeName .' name is already exists.',
            'company_phone.required'    => 'Please fill ' . $this->attributeName . ' phone.',
            'company_email.required'    => 'Please fill ' . $this->attributeName . ' email.',
            'company_email.email'       => 'Wrong format email.',
            'company_address.required'  => 'Please Fill ' . $this->attributeName . ' address.',

            'username.unique'           => 'The ' . $this->attributeName .' already exists.',
            'username.numeric'          => 'The ' . $this->attributeName . ' must be numeric.',
            'password.required'         => 'Please fill password.',
            'password.numeric'          => 'password must be numeric.',

            'password.min'              => 'The password must be at least 6 character.',
            'confirm_password.required' => 'Please fill confirm password.',
            'confirm_password.numeric'  => 'Confirm_password must be numeric.',
            'confirm_password.min'      => 'Confirm password must be at least 6 character.',
            'confirm_password.same'     => 'The password and confirm password must be same.',

            'refund.required'           => 'Please fill refund amount.'
        ];
    }
}
