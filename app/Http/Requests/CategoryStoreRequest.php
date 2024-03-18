<?php

namespace App\Http\Requests;

use App\ErrorMessages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryStoreRequest extends FormRequest
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
            'name' => ['required',
                        Rule::unique('category', 'name')
                        ->where(function ($query) {
                            $query->whereNull('deleted_at');
                        }),
                      ],
            'parent_id'    => ['required'],
            'upload_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => ErrorMessages::REQUIRE_MESSAGE . 'Category Name.',
            'name.unique'           => 'Category Name' . ErrorMessages::UNIQUE_MESSAGE,
            'parent_id.required'    => 'Please select Parent-Category .',
            'upload_photo.required' => ErrorMessages::IMAGE_REQUIRE_MESSAGE,
            'upload_photo.mimes'    => ErrorMessages::INVALID_IMAGE_MESSAGE,
        ];
    }
}