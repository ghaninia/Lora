<?php

namespace App\Services\Discount;

use App\Repositories\Discount\DiscountRepository;
use App\Services\Discount\DiscountServiceInterface;

class DiscountService implements DiscountServiceInterface
{
    public $discount;
    public function __construct(DiscountRepository $discount)
    {
        $this->discount = $discount;
    }

    public function canUsage()
    {
        return
            $this->discount->query()
            ->select("*")
            ->published()
            ->withcount([
                "payments" => function ($query) {
                    $query->succeed();
                }
            ])
            ->groupBy('id')
            ->havingRaw("payments_count < number_of_use");
    }
}
