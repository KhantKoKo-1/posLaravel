<?php

namespace App\Repositories\Discount;

interface DiscountRepositoryInterface
{
    public function createDiscountItems(array $data);
    public function selectAllDiscountPromotion();
    public function selectDiscountPromotion(int $id);
    public function getItemIds(int $id);
    public function updateDiscountPromotion(array $data);
    public function delete(int $id);

}
