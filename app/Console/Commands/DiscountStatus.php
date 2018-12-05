<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DiscountStatus extends Command
{

    protected $signature = 'discount:status' ;

    protected $description = 'If the coupon expired, disable its status';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $date = Carbon::now()->toDateTimeString() ;
        Discount::where('expired_at' , "<" , $date )->update([
            'status' => false
        ]);
    }

}
