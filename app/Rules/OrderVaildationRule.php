<?php

namespace App\Rules;

use App\Constant;
use App\Models\Order;
use Illuminate\Contracts\Validation\Rule;

class OrderVaildationRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $order_check_rows = Order::where('status',Constant::UNPAID)
                            ->whereNull('deleted_at')
                            ->count();               
        return $order_check_rows === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Order has not been paid yet';
    }
}
