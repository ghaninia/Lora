<?php
namespace GhaniniaIR\Captcha\Controllers ;
use App\Http\Controllers\Controller;
use GhaniniaIR\Captcha\Classes\Captcha;

class CaptchaController extends Controller
{
    public function index()
    {
        return Captcha::show();
    }
}
