<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\GetPaymentRequest;
use App\Http\Requests\Frontend\StorePaymentRequest;
use App\Http\Resources\Order\OrderListResource;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Utility;
use Illuminate\Support\Facades\DB;

class PaymentFrontendController extends Controller
{
    private $orderRepository;
    private $paymentRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, PaymentRepositoryInterface $paymentRepository)
    {
        DB::connection()->enableQueryLog();
        $this->orderRepository = $orderRepository;
        $this->paymentRepository = $paymentRepository;
    }

    public function getPayment($id)
    {
        $screen = "Show Get PayMent Form From PaymentFrontendController";
        Utility::saveInfoLog($screen);
        return view('frontend.payment.form', compact('id'));
    }
    public function getOrderDetailFromPayment(GetPaymentRequest $request)
    {
        $screen = "Show Get Order Detail From PaymentFrontendController";
        try {
            $order = $this->orderRepository->selectOrdersByOrderId((int) $request->order_id, (int) $request->shift_id);
            $queryLog = DB::getQueryLog();
            Utility::saveDebugLog($screen, $queryLog);
            return new OrderListResource($order);
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }
    public function storePayment(StorePaymentRequest $request)
    {
        $screen = "Show Store Payment From PaymentFrontendController";
        try {
            $response = $this->paymentRepository->storePayment((array) $request->all());
            if ($response == '200') {
                $queryLog = DB::getQueryLog();
                Utility::saveDebugLog($screen, $queryLog);
                return response()->json(['status' => $response, 'message' => 'success']);
            }
        } catch (\Exception $e) {
            Utility::saveErrorLog($screen, $e->getMessage());
            abort(500);
        }
    }

}