<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NationCodeRule implements Rule
{

    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return (preg_match('/^[0-9]{10}$/',$value)) ;
    }

    public function message()
    {
        return trans("validation.nationcode");
    }
}
