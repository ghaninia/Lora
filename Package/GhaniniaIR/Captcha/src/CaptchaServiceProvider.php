<?php
namespace GhaniniaIR\Captcha;
use GhaniniaIR\Captcha\Classes\Captcha;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
class CaptchaServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__."/routes.php");
        $this->loadTranslationsFrom(__DIR__.'/lang', 'captcha');

        Validator::extend('captcha', 'GhaniniaIR\Captcha\Rules\CaptchaRole@compare' );
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__."/config.php" , "captcha");
    }
}
