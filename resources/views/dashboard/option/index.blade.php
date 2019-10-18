@extends("dashboard.layouts.master")
@section('main')
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <form method="POST" enctype="multipart/form-data" action="{{ route("dashboard.option.store" , ["index" => request("index") ]) }}">
                @csrf
                <div class="dashboard-box margin-top-0">
                    <div class="toolbar">
                        <div class="toolbar__nav">
                            <a href="{{ route("dashboard.option.index") }}" {{ requested("dashboard", true , true  ) }} >داشبورد</a>
                            <a href="{{ route("dashboard.option.index" , ["index" => "user" ]) }}" {{ requested("user",true) }}>کاربری</a>
                            <a href="{{ route("dashboard.option.index" , ["index" => "credit" ]) }}" {{ requested("credit",true) }}>کیف پول</a>
                            <a href="{{ route("dashboard.option.index" , ["index" => "log" ]) }}" {{ requested("log",true) }}>لاگ</a>
                            <a href="{{ route("dashboard.option.index" , ["index" => "social" ]) }}" {{ requested("social",true) }}>شبکه اجتماعی</a>
                        </div>
                    </div>
                    <div class="content with-padding">
                        <div class="row">
                            @switch( request("index") )
                                @case( "log" )
                                    @include("dashboard.option.content.log")
                                @break
                                @case("credit")
                                    @include("dashboard.option.content.credit")
                                @break
                                @case("user")
                                    @include("dashboard.option.content.user")
                                @break
                                @case("social")
                                    @include("dashboard.option.content.social")
                                @break
                                @default
                                    @include("dashboard.option.content.dashboard")
                                @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <button class="button ripple-effect big margin-top-30">ثبت تنظیمات</button>
            </form>
        </div>
    </div>
@stop
