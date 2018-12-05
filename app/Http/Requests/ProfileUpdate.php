<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\PersianCharRule;
use App\Rules\UserNameRule;
use App\Rules\MobileRule;

class ProfileUpdate extends FormRequest
{

    public function authorize()
    {
        return true ;
    }

    public function rules()
    {
        if ($this->request->get("type") == "password")
            return [
                "password" => "required|confirmed"
            ];

        return [
            "firstname" => [ 'required' ],
            "lastname"  => [ 'required' ],
            "gender"    => ['required' , 'in:male,female'] ,
            "username"  => ["required" , new UserNameRule , "max:20" , "min:4" , Rule::unique("users")->ignore($this->user("user")->id) ] ,
            "mobile"    => ["required" , Rule::unique("users")->ignore($this->user("user")->id) , new MobileRule ] ,
            "email"     => ["required" , "email" , Rule::unique("users")->ignore($this->user("user")->id) ] ,
            "picture"   => ["nullable" , "max:2048" , "mimes:jpg,png,jpeg"] ,
            "theme"     => ["nullable" , "string" , "in:red,green,yellow,blue"]
        ];

    }
}
