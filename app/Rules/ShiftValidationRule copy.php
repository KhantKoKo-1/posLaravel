<?php

namespace App\Rules;

use App\Models\Shift;
use Illuminate\Contracts\Validation\Rule;

class ShiftValidationRule implements Rule
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
        $shift_check_rows = Shift::whereNotNull('start_date_time')
                            ->whereNull('end_date_time')
                            ->whereNull('deleted_at')
                            ->count();
        return $shift_check_rows === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You cannot delete while shift is opening';
    }
}
