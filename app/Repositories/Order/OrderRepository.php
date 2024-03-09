<?php

namespace App\Repositories\Order;

use App\Constant;
use App\Models\DiscountItem;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\Order\OrderRepositoryInterface;
use App\ReturnMessage;
use App\Utility;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function orderItem(int $item_id)
    {
        $date = Carbon::now()->format('Y-m-d');
        $item = Item::select('item.id', 'item.name', 'item.price', 'item.code_no', 'item.image')
            ->where('item.id', '=', $item_id)
            ->where('item.status', '=', Constant::ENABLE_STATUS)
            ->whereNull('item.deleted_at')
            ->first();
        $discount_amount = DiscountItem::select(
            DB::raw('CASE 
                                WHEN discount_promotion.percentage IS NULL THEN discount_promotion.amount
                                ELSE discount_promotion.percentage / 100 * ' . $item->price . '
                            END AS discount_amount')
        )
            ->leftJoin('discount_promotion', 'discount_item.discount_id', '=', 'discount_promotion.id')
            ->where('discount_item.item_id', '=', $item_id)
            ->where('discount_promotion.start_date', '<=', $date)
            ->where('discount_promotion.end_date', '>=', $date)
            ->where('discount_item.status', '=', Constant::ENABLE_STATUS)
            ->where('discount_promotion.status', '=', Constant::ENABLE_STATUS)
            ->whereNull('discount_item.deleted_at')
            ->whereNull('discount_promotion.deleted_at')
            ->first();
        if (!isset($discount_amount)) {
            $item['discount_amount'] = 0;
        } else {
            $item['discount_amount'] = $discount_amount->discount_amount;
        }
        return $item;
    }

    public function store(array $data)
    {
        $ins_data['total_amount'] = $data['sub_total'];
        $ins_data['shift_id'] = $data['shift_id'];
        $ins_data = Utility::saveCreated((array) $ins_data, (bool) true);
        DB::beginTransaction();
        $result = Order::create($ins_data);
        if ($result) {
            $detail_datas = $data['item'];
            $order_id = $result->id;
            foreach ($detail_datas as $detail_data) {
                $ins_detail_data['quantity'] = $detail_data['quantity'];
                $ins_detail_data['original_amount'] = $detail_data['original_amount'];
                $ins_detail_data['discount_amount'] = $detail_data['discount_amount'];
                $ins_detail_data['sub_total'] = $detail_data['total_amount'];
                $ins_detail_data['discount_amount'] = $detail_data['discount_amount'];
                $ins_detail_data['order_id'] = $order_id;
                $ins_detail_data['item_id'] = $detail_data['id'];
                $ins_detail_data = Utility::saveCreated((array) $ins_detail_data, (bool) true);
                $detail_res = OrderDetail::create($ins_detail_data);
                if ($detail_res) {
                    $response = ReturnMessage::OK;
                    DB::commit();
                } else {
                    DB::rollback();
                    $response = ReturnMessage::INTERNAL_SERVER_ERROR;
                }
            }
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function updateOrder(array $data)
    {
        $order_id = $data['order_id'];
        $update_form = Order::where('id', $order_id)
            ->whereNull('deleted_at')
            ->first();
        $upd_data['total_amount'] = $data['sub_total'];
        $upd_data['shift_id'] = $data['shift_id'];

        $upd_data = Utility::saveUpdated((array) $upd_data, (bool) $cashier = true);
        DB::beginTransaction();
        $result = $update_form->update($upd_data);
        if ($result) {
            DB::commit();
            $delete_forms = OrderDetail::where('order_id', $order_id)->get();
            foreach ($delete_forms as $delete_form) {
                $delete_form->delete();
            }
            $item_datas = $data['item'];
            $ins_item_data = [];
            $ins_item_data = Utility::saveCreated((array) $ins_item_data, (bool) $cashier = true);
            foreach ($item_datas as $item_data) {
                $ins_item_data['item_id'] = $item_data['id'];
                $ins_item_data['quantity'] = $item_data['quantity'];
                $ins_item_data['original_amount'] = $item_data['original_amount'];
                $ins_item_data['discount_amount'] = $item_data['discount_amount'];
                $ins_item_data['sub_total'] = $item_data['total_amount'];
                $ins_item_data['order_id'] = $order_id;
                $item_res = OrderDetail::create($ins_item_data);
                if ($item_res) {
                    $response = ReturnMessage::OK;
                    DB::commit();
                } else {
                    DB::rollback();
                    $response = ReturnMessage::INTERNAL_SERVER_ERROR;
                }
            }
        } else {
            DB::rollback();
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function selectOrdersByShiftId(int $shift_id)
    {
        $orders = Order::selectRaw('CONCAT("' . $shift_id . '", "-", id, "-", DATE_FORMAT(created_at, "%Y%m%d")) as order_no')
            ->addSelect('id', 'shift_id', 'status', 'created_at')
            ->where('shift_id', $shift_id)
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();
        return $orders;
    }

    public function selectOrdersByOrderId(int $orderid, int $shift_id)
    {
        $orders = Order::selectRaw('CONCAT("' . $shift_id . '", "-", id, "-", DATE_FORMAT(created_at, "%Y%m%d")) as order_no')
            ->addSelect('id', 'shift_id', 'status', 'created_at')
            ->where('id', $orderid)
            ->whereNull('deleted_at')
            ->first();
        return $orders;
    }

    public function changeOrderStatus(int $order_id, int $status)
    {
        $order = Order::find($order_id);
        $data['status'] = $status;
        $data = Utility::saveUpdated((array) $data, (bool) true);
        $result = $order->update($data);
        if ($result) {
            $response = ReturnMessage::OK;
        } else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }

    public function fetchOrderItemByOrderId(int $order_id)
    {
        $item_id = OrderDetail::select('item_id', 'quantity')
            ->where('order_id', $order_id)
            ->whereNull('deleted_at')
            ->get();
        $order_items = [];
        $quantity = [];

        foreach ($item_id as $item_row) {
            $item = $this->orderItem((int) $item_row['item_id']);
            array_push($order_items, $item);
            array_push($quantity, $item_row['quantity']);
        }
        foreach ($quantity as $index => $qty) {
            $order_items[$index]['quantity'] = $qty;
        }
        return $order_items;
    }

}