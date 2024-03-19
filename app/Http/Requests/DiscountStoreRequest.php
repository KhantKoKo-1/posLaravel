<?php

namespace App\Http\Requests;

use App\Rules\CashAmountValid;
use App\Rules\PromotionDateRule;
use App\Http\Requests\BaseFormRequest;

class DiscountStoreRequest extends BaseFormRequest
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
        $rules = [
            'name'          => ['required'],
            'discount_type' => ['required'],
            'start_date'    => ['required', 'date'],
            'end_date'      => ['required', 'date', 'after:start_date'],
            'item'          => ['required','array',new PromotionDateRule($this->start_date, $this->end_date)],
        ];

        // If discount_type is 'percentage', validate that 'amount' is not greater than 100%
        if ($this->discount_type == 'percentage') {
            $rules['amount'] = ['required', 'numeric', 'max:100'];
        } else {
            $rules['amount'] = ['required', 'numeric', 'gt:100',new CashAmountValid($this->item)];
        }

        return $rules;
    }

    protected $attributeName = 'discount';
}
