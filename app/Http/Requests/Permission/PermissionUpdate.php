<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"  => [ ($permission->default ? "nullable" : "required") , new UserNameRule , "max:20" , "min:3" , Rule::unique("permissions")->ignore($permission->id) ] ,
            "description" => ['nullable' , "max:300"] ,
            "default" => ['nullable' , 'boolean'] ,
        ];
    }
}
