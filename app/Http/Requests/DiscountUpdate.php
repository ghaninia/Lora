<?php

namespace App\Http\Requests;

use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountUpdate extends FormRequest
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
            'code' => [ Rule::unique('discounts')->ignore( $this->get("code") , 'code' ) , 'required' , 'regex:/^([A-Z0-9]){10}$/' ] ,
            'number_of_use' => ['required' , 'numeric' , 'min:1'] ,
            'description' => ['required' ] ,
            'expired_at' => ['required'] ,
            'haveAmount' => [ 'required' , 'boolean' ],
            'percent' => ['required_if:haveAmount,==,0' , "numeric" , "min:1" , "max:100" ] ,
            'amount' => ['required_if:haveAmount,==,1' , 'numeric' ] ,
        ];
    }
}
