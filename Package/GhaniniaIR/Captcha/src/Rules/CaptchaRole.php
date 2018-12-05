<?php
namespace GhaniniaIR\Captcha\Rules;
use Illuminate\Contracts\Validation\Rule;
use GhaniniaIR\Captcha\Classes\Captcha;
class CaptchaRole
{
    public function compare($attribute, $value)
    {
        return Captcha::compare(strtolower($value)) ;
    }
}
