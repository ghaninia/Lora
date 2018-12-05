<?php
namespace App\Http\Requests;
use App\Models\Permission;
use App\Rules\UserNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class PermissionUpdate extends FormRequest
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
        $permission = Permission::find(basename(URL::current())) ;
        return [
            "name"  => [ ($permission->default ? "nullable" : "required") , new UserNameRule , "max:20" , "min:3" , Rule::unique("permissions")->ignore($permission->id) ] ,
            "description" => ['nullable' , "max:300"] ,
            "default" => ['nullable' , 'boolean'] ,
        ];
    }
}
