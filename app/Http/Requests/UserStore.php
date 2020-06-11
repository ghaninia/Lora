<?php
namespace App\Http\Requests;
use App\Models\Role;
use App\Rules\UserNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\MobileRule;

class UserStore extends FormRequest
{

    public function authorize()
    {
        return true ;
    }

    public function rules()
    {
        return [
            'type'      => 'required|in:password,profile' ,
            'status'    => 'nullable|boolean' ,
            'role_id'   => ['nullable','numeric' , Rule::in(Role::pluck('id')->toArray()) ] ,
            "gender"    => ['required' , 'in:male,female'] ,
            "username"  => ["required" , new UserNameRule , "max:20" , "min:4" , "unique:users" ] ,
            "mobile"    => ["required" , "unique:users" , new MobileRule ] ,
            "email"     => ["required" , "email" , "unique:users" ] ,
            "picture"   => ["nullable" , "max:2048" , "mimes:jpg,png,jpeg"] ,
            "theme"     => ["nullable" , "string" , "in:red,green,yellow,blue"],
            "password" => "required|confirmed"
        ];
    }
}
