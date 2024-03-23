<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseFormRequest;

class ItemStoreRequest extends BaseFormRequest
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
            'price'        => ['required','numeric','max:9'],
            'quantity'     => ['required','numeric','max:9'],
            'upload_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    protected $attributeName = 'item';
}