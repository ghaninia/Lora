<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => [ 'unique:discounts' , 'required' , 'regex:/^([A-Z0-9]){10}$/' ] ,
            'number_of_use' => ['required' , 'numeric' , 'min:1'] ,
            'description' => ['required' ] ,
            'expired_at' => ['required'] ,
            'haveAmount' => [ 'required' , 'boolean' ],
            'percent' => ['required_if:haveAmount,==,0' , "numeric" , "min:1" , "max:100" ] ,
            'amount' => ['required_if:haveAmount,==,1' , 'numeric' ] ,
        ];
    }
}
