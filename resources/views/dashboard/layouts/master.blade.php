<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($information['title']) ? $information['title'] : option("site_title" , config('dashboard.title') )  }}</title>
    <meta type="description" content="{{ isset($information['desc']) ? $information['desc'] : option("site_description" , config('dashboard.desc') ) }}">
    @access("ticket")
        <meta name="ticket-url" content="{{ route('dashboard.ticket.index') }}">
    @endaccess
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset(sprintf('assets/dashboard/css/colors/%s.css' , theme() )) }}">
</head>

<body class="gray">
    <div id="wrapper">
        @include("dashboard.layouts.header")
        <div class="clearfix"></div>
        <!-- Dashboard Container -->
        <div class="dashboard-container">
            @include("dashboard.layouts.sidebar")
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
                            @include("dashboard.layouts.footer")
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
                                                <a href="{{ route('dashboard.main') }}">{{ trans('dashboard.sidebar.main_menu') }}</a>
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
                        @include("dashboard.layouts.footer")
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/dashboard/js/app.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/librarys.js') }}"></script>
</body>
</html>


