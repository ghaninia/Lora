<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\FactorPayments;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Larabookir\Gateway\Enum;

class FactorController extends Controller
{

    public function payments(FactorPayments $request)
    {

        $me = me()->access('factor.payments') ;
        $username = $request->input('username') ;
        $transactionId = $request->input('transaction_id') ;
        $trackingCode = $request->input('tracking_code') ;
        $discountCode = $request->input('discount_code') ;
        $status = $request->input('status') ;
        $periodTime = $request->input('period_time') ;
        $amount = $request->input('amount') ;

        $rangeCreait = Payment::select([
            DB::raw("MIN(amount) as min") ,
            DB::raw("MAX(amount) as max")
        ])->first();


        $payments = Payment::select( ['users.username' , 'discounts.code' , 'payments.*'] )
            ->when( $me , function ($query){
            } , function ($query){
                $query->where('users.user_id' , me()->id ) ;
            })
            ->when( $username , function ($query) use ($username) {
                $query->where('users.username' , $username ) ;
            })
            ->when( $transactionId , function ($query) use ($transactionId) {
                $query->where("payments.transaction_id" , $transactionId ) ;
            } )
            ->when( $trackingCode , function ($query) use ($trackingCode) {
                $query->where("payments.tracking_code" , $trackingCode ) ;
            } )
            ->when( $discountCode , function ($query) use ($discountCode) {
                $query->where("discounts.code" , $discountCode ) ;
            })
            ->when( $status , function ($query) use ($status) {
                $query->where('payments.status' , $status ) ;
            })
            ->when( $periodTime , function ($query) {
                $query->where( PeriodDate(false , 'payments.created_at') ) ;
            })
            ->when($amount , function ($query) use ($amount){
                $amount = explode(',' , $amount) ;
                $query->where('payments.amount' , '>=' , changeCurrency($amount[0] , 'rial') )
                      ->where('payments.amount' , '<=' , changeCurrency($amount[1] , 'rial') );
            })

            ->leftjoin('users', 'user_id', '=', 'users.id')
            ->leftjoin('discounts', 'discount_id', '=', 'discounts.id')
            ->with("transaction.log" , 'user' , 'discount')
            ->orderBy( $request->input('orderBy' , 'created_at') , $request->input('order' , 'desc') )
            ->paginate( option("paginate_size" , config('dash.paginate_size') ) ) ;

        $information = [
            'title' => trans('dashboard.factor.payment') ,
            'desc'  => trans('dashboard.factor.payment_label') ,
            'breadcrumb' => [
                trans('dashboard.factor.payment') => null
            ]
        ];

        $statusPayment = [
            Enum::TRANSACTION_INIT ,
            Enum::TRANSACTION_SUCCEED ,
            Enum::TRANSACTION_FAILED
        ];

        return view("dashboard.factor.payments" , compact('payments' , 'information' , 'rangeCreait' , 'statusPayment') ) ;
    }

    public function factors(Request $request)
    {

    }
}
