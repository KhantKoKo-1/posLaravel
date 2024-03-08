<?php

namespace App\Repositories\Item;

interface ItemRepositoryInterface
{
    public function createItem(array $data);
    public function selectAllItems(bool $order_items);
    public function selectItem(bool $order_item,int $id);
    public function updateItem(array $data);
    public function deleteItem(int $id);

}
