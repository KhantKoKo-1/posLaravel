<?php

namespace App\Http\Requests;

use App\ErrorMessages;
use App\Rules\CashAmountValid;
use App\Rules\PromotionDateRule;
use Illuminate\Foundation\Http\FormRequest;

class DiscountStoreRequest extends FormRequest
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
            $rules['amount'] = ['required', 'numeric', 'gt:99',new CashAmountValid($this->item)];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'          => ErrorMessages::REQUIRE_MESSAGE . 'Discount Name.',
            'discount_type.required' => ErrorMessages::CHOOSE_REQUIRE_MESSAGE . 'Discount Type.',
            'amount.required'        => ErrorMessages::REQUIRE_MESSAGE . 'Discount Amount.',
            'amount.numeric'         => 'Discount Amount' . ErrorMessages::NUMERIC_MESSAGE,
            'amount.max'             => 'The Discount Percentage Must Be Between 0% And 100%.',
            'start_date.required'    => ErrorMessages::REQUIRE_MESSAGE . 'Discount Start Date.',
            'start_date.date'        => ErrorMessages::REQUIRE_MESSAGE . 'Valid Date Format.',
            'end_date.required'      => ErrorMessages::REQUIRE_MESSAGE . 'Discount End Date.',
            'end_date.date'          => ErrorMessages::REQUIRE_MESSAGE . 'Valid Date Format.',
            'end_date.after'         => 'End Date Is Greater Than Start Date.',
            'item.required'          => ErrorMessages::CHOOSE_REQUIRE_MESSAGE . 'Discount Item .',
        ];
    }
}