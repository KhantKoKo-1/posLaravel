<?php

namespace App\Http\Requests;

use App\ErrorMessages;
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
            'id.required'              => ErrorMessages::REQUIRE_MESSAGE . 'Category Id.',
            'id.numeric'               => 'Category Id' . ErrorMessages::NUMERIC_MESSAGE,
            'name.required'            => ErrorMessages::REQUIRE_MESSAGE . 'Category Name.',
            'name.unique'              => 'Category name' . ErrorMessages::UNIQUE_MESSAGE,
            'upload_photo.required_if' => ErrorMessages::IMAGE_REQUIRE_MESSAGE,
            'upload_photo.mimes'       => ErrorMessages::INVALID_IMAGE_MESSAGE,
        ];
    }
}