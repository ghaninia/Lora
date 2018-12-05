<?php
Route::get(
    config("captcha.route_url") ,
    '\GhaniniaIR\Captcha\Controllers\CaptchaController@index'
)
    ->middleware( config("captcha.route_middleware") )
    ->name( config("captcha.route_name") );