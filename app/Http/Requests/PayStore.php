<?php

namespace App\Http\Requests;
use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayStore extends FormRequest
{

    public function authorize()
    {
        return true ;
    }


    public function rules()
    {

        $canUsageDiscounts = Discount::canUsage()->pluck('code')->toArray() ;

        $min = currency(config('dashboard.min_credit'))['currency'] ;
        $max = currency(config('dashboard.max_credit'))['currency'] ;

        return [
            'amount' => [
                'required' ,
                'numeric' ,
                'min:'.$min ,
                'max:'.$max ] ,
                'haveDiscount' => [ 'required' , 'boolean'
            ],

            'discount' => ['required_if:haveDiscount,==,1' , 'size:10' , Rule::in($canUsageDiscounts) ]
        ];
    }
}
