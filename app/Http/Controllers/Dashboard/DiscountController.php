<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountStore;
use App\Http\Requests\DiscountUpdate;
use App\Models\Discount;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{

    public function index(Request $request)
    {
        $s = $request->input('s') ;
        //* مرتب سازی بر اساس تعداد زمان باقی مونده کد تخفیف *//
        $discounts = Discount::with('payments.user')
            ->when( $s , function ($query) use ($s) {
                $query->where('code' , $s) ;
            })
            ->select(["*" , DB::raw("CURRENT_TIMESTAMP() - discounts.expired_at as difference_date") ])
            ->orderBy('difference_date')
            ->paginate( option("paginate_size" , config('dash.paginate_size') ) ) ;

        $information = [
            'title' => trans('dashboard.discounts.label') ,
            'desc'  => trans('dashboard.discounts.desc') ,
            'breadcrumb' => [
                trans('dashboard.discounts.label') => null
            ]
        ];

        return view('dashboard.discount.index' , compact('discounts' , 'information') ) ;
    }

    public function store(DiscountStore $request)
    {

        Discount::create([
            'code' => $request->input('code') ,
            'description' => $request->input('description') ,
            'number_of_use' => $request->input('number_of_use') ,
            'expired_at' => Carbon::parse($request->input('expired_at'))->toDateTimeString() ,
            'percent' => $request->input('percent' , 0) ,
            'amount'  => $request->input('amount' , 0) ,
        ]);

        return RepMessage( trans('dashboard.messages.success.discounts.create') ) ;
    }


    public function show(Discount $discount , Request $request)
    {

        $information = [
            'title' => trans('dashboard.discounts.show_label') ,
            'desc'  => trans('dashboard.discounts.show_desc') ,
            'breadcrumb' => [
                trans('dashboard.discounts.label') => route('dashboard.discount.index') ,
                $discount->code => null
            ]
        ] ;

        $discount = $discount->load('payments') ;
        $username = request()->input('username') ;
        $period_time = request()->input('period_time') ;

        $payments = Payment::has('discount')
            ->select([
                'users.username' ,
                DB::raw("CONCAT(users.firstname , ' ' , users.lastname) AS fullname") ,
                'payments.*'
            ])
            ->join("users" , 'payments.user_id' , '=' , 'users.id')
            ->when($username , function ($query) use ($username){
                $query->where('users.username' , "like" , "%{$username}%") ;
            })
            ->when($period_time , function ($query){
                $query->where( PeriodDate(false , 'payments.created_at') ) ;
            })
            ->orderBy( $request->input('orderBy' , 'created_at') , $request->input('order' , 'desc') )
            ->paginate( option("paginate_size" , config('dash.paginate_size') ) ) ;

        return view('dashboard.discount.show' , compact('discount' , 'information' , 'payments') ) ;
    }


    public function update(DiscountUpdate $request, Discount $discount)
    {
        if ($discount->amount > 0)
            $amount = changeCurrency( $request->input('amount') , 'rial') ;
        else
            $amount = $request->input('amount') ;

        $discount->update([
            'code' => $request->input('code') ,
            'description' => $request->input('description') ,
            'number_of_use' => $request->input('number_of_use') ,
            'expired_at' => Carbon::parse($request->input('expired_at'))->toDateTimeString() ,
            'percent' => $request->input('percent' , 0) ,
            'amount'  => $amount ,
        ]) ;

        return redirect()->route("dashboard.discount.show" , ['discount' => $discount->code])->with([
            'message' => trans('dashboard.messages.success.discounts.update') ,
            'status' => true ,
        ]);
    }

    public function destroy($id)
    {
        //
    }

}
