@extends('auth.layouts.master')
@section('content')
    <p >{{ $email }}</p>
    <form class="login100-form validate-form" action="{{ route('password.request') }}" method="post">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">


        <div class="wrap-input100 validate-input" data-validate = "پست الکترونیکی نامعتبر است.">
            <input class="input100" type="text" name="email" autocomplete="off">
            <span class="focus-input100" data-placeholder="پست الکترونیکی"></span>
        </div>
        @if($errors->has("email"))
            <label class="error">{{ $errors->first("email") }}</label>
        @endif

        <div class="wrap-input100 validate-input" data-validate="گذرواژه را وارد نمایید .">
            <span class="btn-show-pass">
                <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" name="password" autocomplete="off">
            <span class="focus-input100" data-placeholder="گذرواژه جدید"></span>
        </div>
        @if($errors->has("password"))
            <label class="error">{{ $errors->first("password") }}</label>
        @endif


        <div class="wrap-input100 validate-input" data-validate="گذرواژه را وارد نمایید .">
            <span class="btn-show-pass">
                <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" name="password_confirmation" autocomplete="off">
            <span class="focus-input100" data-placeholder="تکرار گذرواژه"></span>
        </div>
        @if($errors->has("password_confirmation"))
            <label class="error">{{ $errors->first("password_confirmation") }}</label>
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
                <button class="login100-form-btn">تغییر گذرواژه</button>
            </div>
        </div>

        <div class="text-center p-t-10 text-small">
            <span class="txt1">
                <a href="{{ route('login') }}">ورود به حساب کاربری</a>
            </span>
        </div>
    </form>
@endsection
