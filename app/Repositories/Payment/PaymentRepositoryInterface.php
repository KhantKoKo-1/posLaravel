<?php

namespace App\Repositories\Payment;

interface PaymentRepositoryInterface
{
    public function storePayment(array $data);
}
