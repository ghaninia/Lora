@extends("layouts.dash")
@section('main')
    <div class="fun-facts-container">

        <div class="fun-fact" data-fun-fact-color="#FFCC00">
            <div class="fun-fact-text">
                @php
                    $currency = me()->credit ;
                    $currency = currency($currency) ;
                @endphp
                <span>{{ sprintf("%s (%s)" , trans('dash.profile.credit') , $currency['type'] ) }}</span>
                <h4>{{ $currency['currency'] }}</h4>
            </div>
            <div class="fun-fact-icon"><i class="icon-feather-dollar-sign"></i></div>
        </div>

        @access('user')
        <div class="fun-fact" data-fun-fact-color="#36bd78">
            <div class="fun-fact-text">
                <span>{{ $data['user']['text'] }}</span>
                <h4>{{ $data['user']['count'] }}</h4>
            </div>
            <div class="fun-fact-icon"><i class="icon-material-outline-group"></i></div>
        </div>
        @endaccess

        @access('permission')
        <div class="fun-fact" data-fun-fact-color="#2a41e6">
            <div class="fun-fact-text">
                <div class="fun-fact-text">
                    <span>{{ $data['permission']['text'] }}</span>
                    <h4>{{ $data['permission']['count'] }}</h4>
                </div>
            </div>
            <div class="fun-fact-icon"><i class="icon-material-outline-extension"></i></div>
        </div>
        @endaccess
    </div>
@stop