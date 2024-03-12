<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemStoreRequest extends FormRequest
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
            'name'         => ['required',
                                Rule::unique('item', 'name')
                                ->where(function ($query) {
                                    $query->whereNull('deleted_at');
                                }),
                             ],
            'category_id'  => ['required'],
            'price'        => ['required'],
            'quantity'     => ['required'],
            'upload_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Please fill item name .',
            'name.unique'           => 'Item name is already exists .',
            'category_id.required'  => 'Please select parent category .',
            'price.required'        => 'Please fill price .',
            'quantity.required'     => 'Please fill quantity .',
            'upload_photo.required' => 'Please upload photo.',
            'upload_photo.mimes'    => 'Please select valid photo type.',
        ];
    }
}