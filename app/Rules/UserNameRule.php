<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;

class UserNameRule implements Rule
{

    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return preg_match('/^[A-Za-z0-9_]+$/', $value) ;
    }


    public function message()
    {
        return trans("validation.username");
    }
}
