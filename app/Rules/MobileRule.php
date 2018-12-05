<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;

class MobileRule implements Rule
{

    public function __construct()
    {

    }

    public function passes($attribute, $value)
    {
        return preg_match("/^09[0-9]{9}$/" , $value ) ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans("validation.mobile");
    }
}
