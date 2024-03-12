<?php

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function orderItem(int $id);
    public function store(array $data);
    public function selectOrdersByShiftId(int $shift_id);
    public function selectOrdersByOrderId(int $orderId,int $shift_id);
    public function changeOrderStatus(int $order_id,int $status);
    public function fetchOrderItemByOrderId(int $order_id);
    public function updateOrder(array $data);
}
