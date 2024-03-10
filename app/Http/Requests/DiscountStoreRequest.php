<?php

namespace App\Http\Requests;

use App\Rules\CashAmountValid;
use App\Rules\PromotionDateRule;
use Illuminate\Foundation\Http\FormRequest;

class DiscountStoreRequest extends FormRequest
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

    public function messages()
    {
        return [
            'name.required'           => 'Please fill discount name .',
            'discount_type.required'  => 'Please choose discount type .',
            'amount.required'         => 'Please fill discount amount .',
            'amount.numeric'          => 'Discount amount must be numeric .',
            'amount.max'              => 'Discount percentage must between 0 and 100% ',
            'start_date.required'     => 'Please fill discount start date .',
            'start_date.date'         => 'Please fill valid date format .',
            'end_date.required'       => 'Please fill discount end date .',
            'end_date.date'           => 'Please fill valid date format .',
            'end_date.after'          => 'End date is greater than start date .',
            'item.required'           => 'Please choose discount item .',
            // 'item.array'              => 'Discount item must be array.',
        ];
    }
}
