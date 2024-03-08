<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\DiscountItem;
use App\Utility;

class PromotionDateRule implements Rule
{
    protected $startDate;
    protected $endDate;
    protected $id;
    protected $itemNames = [];
    protected $validationFailed = false;

    /**
     * Create a new rule instance.
     *
     * @param array $items
     */
    public function __construct($startDate, $endDate, $id = null)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->id        = $id;
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
        $return = true;
        if ($this->startDate != null && $this->endDate != null) {
            // $id = $this->input('id');

            $startDateFormat = Utility::dateFormatYmd($this->startDate);
            $endDateFormat   = Utility::dateFormatYmd($this->endDate);

            if ($value != null) {
                foreach ($value as $itemId) {
                    $checkPromotionDate = DiscountItem::select('item.name')
                                        ->join('discount_promotion', 'discount_item.discount_id', '=', 'discount_promotion.id')
                                        ->join('item', 'discount_item.item_id', '=', 'item.id')
                                        ->where('discount_item.item_id', $itemId)
                                        ->where('discount_item.discount_id', '!=', $this->id)
                                        ->whereDate('discount_promotion.end_date', '>=', $startDateFormat)
                                        ->whereDate('discount_promotion.start_date', '<=', $endDateFormat)
                                        ->whereNull('discount_item.deleted_at')
                                        ->whereNull('discount_promotion.deleted_at')
                                        ->first();
                    if ($checkPromotionDate != null) {
                        $return  = false;
                        array_push($this->itemNames, $checkPromotionDate->name);
                    }
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
        return "Promotion date is already exists for the following items: {$itemNamesString}.";
    }
}
