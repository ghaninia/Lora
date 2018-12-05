<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($information['title']) ? $information['title'] : config('dash.title')  }}</title>
    <meta type="description" content="{{ isset($information['desc']) ? $information['desc'] : config('dash.desc')  }}">


    @access("ticket")
    <meta name="ticket-url" content="{{ route('dashboard.ticket.index') }}">
    @endaccess
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset(sprintf('asset/css/colors/%s.css' , theme() )) }}">


</head>


<body class="gray">

    <div id="wrapper">

        @include("layouts.dash_header")

        <div class="clearfix"></div>

        <!-- Dashboard Container -->

        <div class="dashboard-container">

            @include("layouts.dash_sidebar")

            <!-- Dashboard Content ============ -->

            <div class="dashboard-content-container" data-simplebar>
                @if(in_array( \Route::currentRouteName() , ['dashboard.operator.sysusr.show'] ))

                    <div class="dashboard-content-inner">
                        @if(session()->has(['status' , 'message']))
                            <div class="notification {{ session()->pull('status') ? "success" : "error" }} closeable">
                                <p>{{ session()->pull('message') }}</p>
                                <a class="close" href="#"></a>
                            </div>
                        @endif
                        @yield("main")
                            @include("layouts.dash_footer")
                    </div>

                @else

                    <div class="dashboard-content-inner">

                        @if(isset($information['title'] , $information['desc']))
                        <!-- Dashboard Headline -->
                            <div class="dashboard-headline">
                                <h1>{{ $information['title'] }}</h1>

                                @if(isset($information['desc'])) <h4 class="margin-top-7">{{ $information['desc'] }}</h4> @endif

                                <!-- Breadcrumbs -->

                                @if(isset($information['breadcrumb']) && is_array($information['breadcrumb']))

                                    <nav id="breadcrumbs" class="dark">

                                        <ul class="breadcrumb">

                                            <li class="breadcrumb-item">
                                                <a href="{{ route('dashboard.main') }}">{{ trans('dash.sidebar.main_menu') }}</a>
                                            </li>

                                            @foreach($information['breadcrumb'] as $name => $link )
                                                <li class="breadcrumb-item">
                                                    @if(!! $link)
                                                        <a href="{{ $link }}">
                                                            {{ $name }}
                                                        </a>
                                                    @else
                                                        {{ $name }}
                                                    @endif
                                                </li>
                                            @endforeach

                                        </ul>

                                    </nav>

                                @endif
                            </div>
                        @endif


                        @if(session()->has(['status' , 'message']))

                            <div class="notification {{ session()->pull('status') ? "success" : "error" }} closeable">
                                <p>{{ session()->pull('message') }}</p>
                                <a class="close" href="pages-user-interface-elements.html#"></a>
                            </div>

                        @endif

                        @yield("main")

                        @include("layouts.dash_footer")

                    </div>
                @endif
            </div>
        </div>
    </div>


<!-- Scripts
================================================== -->
<script src="{{ asset('asset/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('asset/js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('asset/js/mmenu.min.js') }}"></script>


<script src="{{ asset('asset/js/tippy.all.min.js') }}"></script>
<script src="{{ asset('asset/js/simplebar.min.js') }}"></script>
<script src="{{ asset('asset/js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('asset/js/bootstrap-select.min.js') }}"></script>

<script src="{{ asset('asset/js/clipboard.min.js') }}"></script>
<script src="{{ asset('asset/js/counterup.min.js') }}"></script>
<script src="{{ asset('asset/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('asset/js/slick.min.js') }}"></script>
<script src="{{ asset('asset/js/custom.js') }}"></script>
<script src="{{ asset('asset/js/chart.min.js') }}"></script>
<script src="{{ asset('asset/js/theme.js') }}"></script>

<script type="text/javascript" src="{{ asset('asset/js/ticket.js') }}"></script>
<!-- plugins -->
<script src="{{ asset('asset/libs/library.js') }}"></script>

<script src="{{ asset('asset/libs/sweetalert/sweetalert.js') }}"></script>
<link rel="stylesheet" href="{{ asset('asset/libs/sweetalert/sweetalert.css') }}">
@yield("plugins")
</body>
</html>


