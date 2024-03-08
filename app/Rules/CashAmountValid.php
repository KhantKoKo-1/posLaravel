<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Item;

class CashAmountValid implements Rule
{
    protected $items;
    protected $itemNames = [];

    /**
     * Create a new rule instance.
     *
     * @param array $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $return  = true;
        if ($this->items != null) {
            foreach ($this->items as $itemId) {
                $item = Item::find($itemId);
                if ($value > $item->price) {
                    $return = false;
                    array_push($this->itemNames, $item->name);
                }
            }
        }
        return $return;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $itemNamesString = implode(', ', $this->itemNames);
        return "The amount is greater than the price for the following items: {$itemNamesString}.";
    }
}
