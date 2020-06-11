<?php
namespace App\Http\Requests;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\UserNameRule;
use App\Rules\MobileRule;

class UserUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = $this->route('user') ;

        if ($this->request->get('type') == 'password')
            return [
                "password" => "required|confirmed"
            ];

        return [
            'type'      => 'required|in:password,profile' ,
            'status'    => 'nullable|boolean' ,
            'role_id'   => ['nullable','numeric' , Rule::in(Role::pluck('id')->toArray()) ] ,
            "gender"    => ['required' , 'in:male,female'] ,
            "username"  => ["required" , new UserNameRule , "max:20" , "min:4" , Rule::unique("users")->ignore($user->id) ] ,
            "mobile"    => ["required" , Rule::unique("users")->ignore($user->id) , new MobileRule ] ,
            "email"     => ["required" , "email" , Rule::unique("users")->ignore($user->id) ] ,
            "picture"   => ["nullable" , "max:2048" , "mimes:jpg,png,jpeg"] ,
            "theme"     => ["nullable" , "string" , "in:red,green,yellow,blue"]
        ];
    }
}
