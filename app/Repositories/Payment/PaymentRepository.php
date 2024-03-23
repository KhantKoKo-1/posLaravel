<?php

namespace App\Repositories\Payment;

use App\Constant;
use App\Models\CashFlow;
use App\Models\Order;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\ReturnMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{
    // public function storePayment(array $data)
    // {

    //     $shift_id = $data['shift_id'];
    //     $order_id = $data['order_id'];

    //     $update_form = Order::find($order_id);
    //     $upd_data['payment'] = $data['payment'];
    //     $upd_data['refund'] = $data['refund'];
    //     $upd_data['status'] = Constant::PAID;
    //     $upd_data = Utility::saveUpdated((array) $upd_data, (bool) true);
    //     DB::beginTransaction();
    //     $result = $update_form->update($upd_data);
    //     if ($result) {
    //         if (isset($data['cash_amount'])) {
    //             $payment_datas = $data['cash_amount'];
    //             foreach ($payment_datas as $payment_data) {

    //                 $ins_payment_data['cash'] = $payment_data['origin_amount'];
    //                 $ins_payment_data['quantity'] = $payment_data['quantity'];

    //                 $ins_payment_data['shift_id'] = $shift_id;
    //                 $ins_payment_data = Utility::saveCreated((array) $ins_payment_data, (bool) true);

    //                 dd($ins_payment_data);
    //                 $payment_res = PaymentHistory::create($ins_payment_data);
    //                 if ($payment_res) {
    //                     $response = ReturnMessage::OK;
    //                     DB::commit();
    //                 } else {
    //                     DB::rollback();
    //                     $response = ReturnMessage::INTERNAL_SERVER_ERROR;
    //                 }
    //             }
    //         }
    //     } else {
    //         $response = ReturnMessage::INTERNAL_SERVER_ERROR;
    //     }
    //     return $response;
    // }

    public function storePayment(array $data)
    {
        try {
            $shift_id = $data['shift_id'];
            $order_id = $data['order_id'];

            $update_form = Order::find($order_id);
            $upd_data    = [
                'payment' => $data['payment'],
                'refund'  => $data['refund'],
                'status'  => Constant::PAID,
            ];
            $upd_data = Utility::saveUpdated($upd_data, (bool) true);

            DB::beginTransaction();
            $result = $update_form->update($upd_data);

            if ($result) {
                if (isset($data['cash_amount'])) {
                    // dd($data);
                    foreach ($data['cash_amount'] as $payment_data) {
                        $origin_amount = $payment_data['origin_amount'];
                        $quantity      = ($payment_data['quantity']);

                        $this->updateCashFlow($shift_id, $origin_amount, $quantity);
                    //this works well
                    }
                }
                //error in this stage
                DB::commit();
                return ReturnMessage::OK;
            } else {
                DB::rollback();
                return ReturnMessage::INTERNAL_SERVER_ERROR;
            }

        } catch (\Exception $e) {
            Utility::saveErrorLog('PaymentRepository', $e->getMessage());
            return ReturnMessage::INTERNAL_SERVER_ERROR;
        }
    }

    protected function updateCashFlow($shift_id, $origin_amount, $quantity)
    {
        $cashFlow = CashFlow::where('shift_id', $shift_id)->first();

        if (!$cashFlow) {
            $cashFlow = new CashFlow(['shift_id' => $shift_id]);
        }

        $columnName = $this->getDenominationColumnName($origin_amount);
        // dd($columnName);
        if ($columnName) {

            $cashFlow->$columnName = $quantity;
        }
        dd($cashFlow);
        $cashFlow->save();
    }

    protected function getDenominationColumnName($origin_amount)
    {

        $denominationMapping = [
            50    => '50',
            100   => '100',
            200   => '200',
            500   => '500',
            1000  => '1000',
            5000  => '5000',
            10000 => '10000',
            20000 => '20000',
        ];

        return $denominationMapping[$origin_amount] ?? null;
    }
}
