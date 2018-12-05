<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UserNameRule;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use App\Models\Tag;
use App\Models\Permission;

class RoleUpdate extends FormRequest
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
            "name"  => ["required" , "max:191" , "min:4" , Rule::unique("roles")->ignore(basename(URL::current())) ] ,
            "description" => ['nullable' , "min:4" , "max:300"] ,
            "permissions" => ["nullable" , "array"] ,
            "permissions.*" => ['required' , "string" , Rule::in(Permission::pluck('id')->toArray()) ] ,
            "default" => ['nullable' , 'boolean'] ,
            "picture" => ['nullable' , "mimes:png,jpeg,jpg" , "max:1024"]
        ];
    }
}
