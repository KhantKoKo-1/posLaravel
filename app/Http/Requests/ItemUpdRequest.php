<?php

namespace App\Http\Requests;

use App\Rules\ShiftValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemUpdRequest extends FormRequest
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
            'id'        => ['required','numeric'],
            'name'      => ['required',
                        Rule::unique('item', 'name')
                        ->where(function ($query) {
                            $query->whereNull('deleted_at');
                        })->ignore(request('id')),
                      ],
            // 'parent_id'    => ['required'],
            'upload_photo' => [ 'required_if:has_image,1','image', 'mimes:jpeg,png,jpg,gif'],
            'shift'        => [new ShiftValidationRule()],
        ];
    }


    public function messages()
    {
        return [
            'id.required'              => 'Item id is required',
            'id.numeric'               => 'Item id must be numeric',
            'name.required'            => 'Please fill Item name .',
            'name.unique'              => 'Item name is already exists .',
            // 'parent_id.required'       => 'Please select Parent-Item .',
            'upload_photo.required_if' => 'Please upload photo.',
            'upload_photo.mimes'       => 'Please fill valid photo type.',
        ];
    }
}