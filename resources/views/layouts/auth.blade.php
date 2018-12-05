<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @if(isset($p_title))
            {{ $p_title }}
        @else
            {{ config('dash.title') }}
        @endif
    </title>
    <!-- Scripts -->
    <script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('asset/js/auth.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('asset/css/auth.css') }}" rel="stylesheet">
</head>
<body class="background-auth">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 animated jackInTheBox">
                @yield("content")
            </div>
        </div>
    </div>
</body>
</html>
