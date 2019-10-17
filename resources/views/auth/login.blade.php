@extends('auth.layouts.master')
@section('content')
    <form class="login100-form validate-form" action="{{ route('login') }}" method="post" >
        {{ csrf_field() }}

        <div class="wrap-input100 validate-input" data-validate="نام کاربری را وارد نمایید .">
            <input class="input100" type="text" name="username" autocomplete="off" >
            <span class="focus-input100" data-placeholder="نام کاربری"></span>
        </div>
        @if($errors->has("username"))
            <label class="error">{{ $errors->first("username") }}</label>
        @endif


        <div class="wrap-input100 validate-input" data-validate="گذرواژه را وارد نمایید .">
            <span class="btn-show-pass">
                <i class="zmdi zmdi-eye"></i>
            </span>
            <input class="input100" type="password" name="password" autocomplete="off">
            <span class="focus-input100" data-placeholder="گذرواژه"></span>
        </div>
        @if($errors->has("password"))
            <label class="error">{{ $errors->first("password") }}</label>
        @endif


        <div class="wrap-input100 validate-input recaptcha" data-validate="کدامنیتی را وارد نمایید .">
            <input class="input100" type="text" name="captcha" autocomplete="off" >
            <span class="focus-input100" data-placeholder="کدامنیتی"></span>
            <div class="image" id="captcha">
                <div class="reload"></div>
                <img src="{{ route("captcha") }}">
            </div>
        </div>
        @if($errors->has("captcha"))
            <label class="error">{{ $errors->first("captcha") }}</label>
        @endif

        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button class="login100-form-btn">ورود به حساب کاربری</button>
            </div>
        </div>

        <div class="text-center p-t-10 text-small">
            <span class="txt1">
                <a href="{{ route('password.request') }}">گذرنامه را فراموش کرده ام !؟</a>
            </span>
        </div>

    </form>
@endsection
