<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;


class CategoryUpdRequest extends BaseFormRequest
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

    protected $attributeName = 'category';
}
