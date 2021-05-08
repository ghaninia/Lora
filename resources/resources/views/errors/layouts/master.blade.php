<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @if(isset($p_title))
            {{ $p_title }}
        @else
            {{ config('app.name', 'پُرسَپ' ) }}
        @endif
    </title>
    @if(isset($p_desc)) <meta name="description" content="{{ $p_desc }}"> @endif

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/errors/css/app.css') }}" />
</head>
<body>
    <div class="content">
        <div class="content-box">
            <div class="big-content">
                <div class="list-square">
                    <span class="square"></span>
                    <span class="square"></span>
                    <span class="square"></span>
                </div>
                <div class="list-line">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </div>
                <i class="icon-feather-search" aria-hidden="true"></i>
                <div class="clear"></div>
            </div>
            @yield('content')
        </div>
        <footer>
            <ul>
                <li><a href="{{ route('dashboard.main') }}">{{ trans('dashboard.sidebar.main_menu') }}</a></li>
                <li><a href="{{ route('login') }}">ورود </a></li>
                <li><a href="{{ route('password.request') }}">بازیابی گذرواژه</a></li>
            </ul>
        </footer>
    </div>

    <script src="{{ asset('assets/auth/js/app.js') }}" defer></script>
</body>
</html>
