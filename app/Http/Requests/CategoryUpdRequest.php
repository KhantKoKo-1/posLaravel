<?php

namespace App\Http\Requests;

use App\Rules\ShiftValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryUpdRequest extends FormRequest
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
        return [
            'id'   => ['required','numeric'],
            'name' => ['required',
                        Rule::unique('category', 'name')
                        ->where(function ($query) {
                            $query->whereNull('deleted_at');
                        })->ignore(request('id')),
                      ],
            'upload_photo' => [ 'required_if:has_image,1','image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages()
    {
        return [
            'id.required'              => 'Category id is required',
            'id.numeric'               => 'Category id must be numeric',
            'name.required'            => 'Please fill category name .',
            'name.unique'              => 'Category name is already exists .',
            'upload_photo.required_if' => 'Please upload photo.',
            'upload_photo.mimes'       => 'Please fill valid photo type.',
        ];
    }
}