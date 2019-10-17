@extends('auth.layouts.master')
@section('content')
    @if (session('status'))
        <center>
            <h5 style="font-weight: bold">بازیابی گذرواژه</h5>
            <img src="{{ asset("asset/imgs/email.png") }}" alt="ایمیل" class="w-25 m-2 d-block">
            <h6>{!! session()->pull("status") !!}</h6>
        </center>
    @else
        <form class="login100-form validate-form" action="{{ route('password.email') }}" method="post">
            {{ csrf_field() }}


            <div class="wrap-input100 validate-input" data-validate = "پست الکترونیکی نامعتبر است.">
                <input class="input100" type="text" name="email" autocomplete="off">
                <span class="focus-input100" data-placeholder="پست الکترونیکی"></span>
            </div>
            @if($errors->has("email"))
                <label class="error">{{ $errors->first("email") }}</label>
            @endif

            <div class="wrap-input100 validate-input recaptcha" data-validate="کدامنیتی را وارد نمایید .">
                <input class="input100" type="text" name="captcha" autocomplete="off" >
                <span class="focus-input100" data-placeholder="کدامنیتی"></span>
                <div class="image" id="captcha">
                    <div class="reload"  onclick="recaptcha(this);"></div>
                    <img src="{{ route("captcha") }}">
                </div>
            </div>
            @if($errors->has("captcha"))
                <label class="error">{{ $errors->first("captcha") }}</label>
            @endif

            <div class="container-login100-form-btn">
                <div class="wrap-login100-form-btn">
                    <div class="login100-form-bgbtn"></div>
                    <button class="login100-form-btn">بازیابی گذرواژه</button>
                </div>
            </div>

            <div class="text-center p-t-10 text-small">
                <span class="txt1">
                    <a href="{{ route('login') }}">ورود به حساب کاربری</a>
                </span>
            </div>
        </form>
    @endif
@endsection
