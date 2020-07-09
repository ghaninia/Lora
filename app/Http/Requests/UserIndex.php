<?php
namespace App\Http\Requests;
use App\Models\Role;
use App\Rules\UserNameRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MobileRule;
use Illuminate\Validation\Rule;

class UserIndex extends FormRequest
{

    public function authorize()
    {
        return true ;
    }

    public function rules()
    {
        return [
            "status"     => ['nullable' , 'boolean'] ,
            "genders"    => ['nullable' , 'array' ] ,
            "genders.*"  => ['required' , 'string' , 'in:male,female'] ,
            "roles"      => ['nullable' , 'array' ] ,
            "roles.*"    => ['required' , 'string' , Rule::in(Role::pluck("id")->toArray()) ] ,
            "username"   => ["nullable" , new UserNameRule , "max:100" , "min:4" ] ,
            "mobile"     => ["nullable" , new MobileRule ] ,
            "email"      => ["nullable" , "email"] ,
            "order"      => ['nullable' , 'string' , "in:asc,desc"] ,
            "credit"     => ['nullable' , 'regex:/^[0-9]+,[0-9]+$/']
        ];
    }
}
