<?php

namespace App\Repositories\Payment;

use App\Constant;
use App\ReturnMessage;
use App\Utility;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Repositories\Payment\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function storePayment(array $data)
    {
        $order_id                 = $data['order_id'];
        $update_form              = Order::find($order_id);
        $upd_data['payment']      = $data['payment'];
        $upd_data['refund']       = $data['refund'];
        $upd_data['status']       = Constant::PAID;
        $upd_data                 = Utility::saveUpdated((array) $upd_data,(bool) true);
        DB::beginTransaction();
        $result                   = $update_form -> update($upd_data);
        if ($result) { 
            if(isset($data['cash_amount'])){
                $payment_datas = $data['cash_amount'];
                foreach ($payment_datas as $payment_data) {
                    $ins_payment_data['cash']     = $payment_data['origin_amount'];
                    $ins_payment_data['quantity'] = $payment_data['quantity'];
                    $ins_payment_data['order_id'] = $order_id;
                    $ins_payment_data             = Utility::saveCreated((array) $ins_payment_data,(bool) true);
                    $payment_res                  = PaymentHistory::create($ins_payment_data);
                    if ($payment_res) {
                        $response = ReturnMessage::OK;
                        DB::commit();
                    } else {
                        DB::rollback();
                        $response = ReturnMessage::INTERNAL_SERVER_ERROR;
                    }
                }
        } 
        }else {
            $response = ReturnMessage::INTERNAL_SERVER_ERROR;
        }
        return $response;
    }
}
