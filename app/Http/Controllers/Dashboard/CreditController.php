<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayStore;
use App\Models\Discount;
use App\Models\Payment;
use Illuminate\Http\Request;
use Larabookir\Gateway\Enum;
use Larabookir\Gateway\Zarinpal\Zarinpal;

class CreditController extends Controller
{
    //* نمایش صفحه شارژ کیف پول *//
    //
    public function index()
    {
        $information = [
            'title' => trans('dashboard.credit.charge.text') ,
            'desc' => trans('dashboard.credit.charge.desc') ,
            'breadcrumb' => [
                trans('dashboard.credit.charge.text') => null
            ]
        ] ;
        return view('dashboard.credit.index' , compact('information') ) ;
    }

    public function pay(PayStore $request)
    {

        try {

            $amount = $request->input('amount') ;
            //* در صورتی که کد تخفیف وجود داشت *//

            if ($request->has('discount')) {
                $discount = Discount::whereCode($request->input('discount'))->first();

                if ($discount->percent > 0) {
                    $amount = $amount * $discount->percent / 100;
                    $amount = $request->input('amount') - $amount;
                } else {
                    //*  بر جسب ریاله *//
                    $discountAmount = $discount->amount ;
                    $discountAmount = currency($discountAmount)['currency'] ;
                    $amount = $amount - $discountAmount ;
                }

                $discount = $discount->id;
            } else
                $discount = null;


            $gateway = \Gateway::make(new Zarinpal());
            $gateway->setCallback(route('dashboard.credit.BankResponse'));

            $gateway->price( changeCurrency( $amount , 'rial' ) ); // برجسب تومان

            $gateway->ready();

            $refId = $gateway->refId(); // شماره ارجاع بانک

            $transID = $gateway->transactionId(); // شماره تراکنش

            Payment::create([
                'user_id' => $request->user()->id,
                'discount_id' => $discount,
                'amount' => changeCurrency( $amount , 'rial' ) ,
                'ref_id' => $refId,
                'transaction_id' => $transID,
            ]);

            //* redirect to payment
            return $gateway->redirect();

        }
        catch (\Exception $exception){
            return $exception->getMessage() ;
        }
    }

    public function BankResponse(Request $request)
    {
        try {

            //* ارتباط با درگاه بانکی برای تایید *//
            $gateway = \Gateway::verify();
            $trackingCode = $gateway->trackingCode();
            $refId = $gateway->refId();

            //* درخواست پرداخت جاری رو به من بده *//
            $payment = Payment::with(['discount' , 'user' , 'transaction' ])
                ->where([ 'ref_id' => $refId ])
                ->first() ;

            //* اگر درخواست وجود داشت برو تو شرط *//
            $result = Payment::where(['ref_id' => $refId])->update([
                'tracking_code' => $trackingCode ,
                'status' => Enum::TRANSACTION_SUCCEED
            ]);


            $amountPayment = $payment->amount ;

            if( $result )
            {

                if ($payment->discount)
                {
                    $discount = $payment->discount ;
                    if ($discount->percent > 0) {
                        $percent = 100 - $discount->percent ;
                        $amountPayment = 100 * $amountPayment / $percent ;

                    } else {
                        //*  بر جسب ریاله *//
                        $discountAmount = $discount->amount ;
                        $amountPayment = $amountPayment + $discountAmount ;
                    }
                }


                me()->update([
                    'credit' => me()->credit + $amountPayment ,
                ]);

                return view('dashboard.credit.bankresponse')->with([
                    'message' => trans('dashboard.messages.success.credit.pay') ,
                    'status'  => true ,
                    'payment' => $payment ,
                    'amountPayment' => $amountPayment
                ]);
            }


        } catch ( RetryException $e) {

            return view('dashboard.credit.bankresponse')->with([
                'message' => $e->getMessage() ,
                'status'  => false ,
            ]);

        } catch (\Exception $e) {

            Payment::where([
                'status'         => Enum::TRANSACTION_INIT ,
                'transaction_id' => $request->input('transaction_id')
            ])->update([
                'status' => Enum::TRANSACTION_FAILED
            ]);

            return view('dashboard.credit.bankresponse' )->with([
                'message' => $e->getMessage() ,
                'status'  => false ,
            ]);
        }


    }
}
