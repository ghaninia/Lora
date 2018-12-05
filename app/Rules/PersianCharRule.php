<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PersianCharRule implements Rule
{

    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return !preg_match('/[^x{600}-\x{6FF} $]/u', $value ) ;
    }

    public function message()
    {
        return trans("validation.persian_char");
    }
}
