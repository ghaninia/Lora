<?php

namespace App\Repositories\Payment;

use NamTran\LaravelMakeRepositoryService\Repository\BaseRepository;
use App\Repositories\Payment\PaymentRepositoryInterface;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        //return;
    }
}
