<?php

namespace App\Http\Requests;
use App\Rules\UserNameRule;
use Illuminate\Foundation\Http\FormRequest;

class PermissionStore extends FormRequest
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
            "name"  => [ "required" , new UserNameRule , "max:20" , "min:3" , "unique:permissions" ] ,
            "description" => ['nullable' , "max:300"] ,
            "default" => ['nullable' , 'boolean'] ,
        ];
    }
}
