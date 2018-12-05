<?php
namespace App\Http\Requests;
use App\Models\Discount;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Larabookir\Gateway\Enum;

class FactorPayments extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'orderBy' => [ 'nullable' , 'in:created_at,amount,username'] ,
            'order' => [  'required_with:orderBy' , 'in:asc,desc'] ,
            'username' => ['nullable' , Rule::in( User::pluck('username')->toArray() ) ] ,
            'transaction_id' => ['nullable' , Rule::in( Payment::pluck('transaction_id')->toArray() ) ] ,
            'tracking_code' => ['nullable' , Rule::in( Payment::pluck('tracking_code')->toArray() ) ] ,
            'code' => ['nullable' , Rule::in( Discount::pluck('code')->toArray() ) ] ,
            'status' => ['nullable' , Rule::in([Enum::TRANSACTION_SUCCEED , Enum::TRANSACTION_FAILED,Enum::TRANSACTION_INIT])] ,
            'period_time' => [ 'nullable' , Rule::in(PeriodDate()) ] ,
            'amount' => ['nullable' , 'regex:/^[0-9]+,[0-9]+$/']
        ];
    }
}
