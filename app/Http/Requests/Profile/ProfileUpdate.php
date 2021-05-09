<?php

namespace App\Http\Requests\Profile;

use App\Enum\UserEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\UserNameRule;
use App\Rules\MobileRule;

class ProfileUpdate extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = authunticate()->id();
        return [
            "firstname" => ['nullable'],
            "lastname"  => ['nullable'],
            "gender"    => ['nullable', Rule::in(UserEnum::GENDERS)],
            "username"  => ["required", new UserNameRule, "unique:users,username,{$id}"],
            "mobile"    => ["required", new MobileRule, "unique:users,mobile,{$id}"],
            "email"     => ["required", "unique:users,email,{$id}"],
            "picture"   => ["nullable", "image"],
            "theme"     => ["nullable", Rule::in(UserEnum::THEMES)]
        ];
    }
}
