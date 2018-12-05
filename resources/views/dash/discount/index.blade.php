@extends('layouts.dash')

@section('main')

<div class="row">

    <div class="col-lg-5">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3>
                    {{ trans('dash.discounts.create') }}
                </h3>
            </div>

            <div class="content with-padding">
                <form action="{{ route('dashboard.discount.store') }}" method="POST">
                    @csrf

                    <div class="submit-field">
                        <h5>{{ trans('dash.items.description') }}</h5>
                        <input name="description" class="with-border" placeholder="{{ trans('dash.items.description') }}" value="{{ old('description') }}">
                        @if($errors->has("description"))
                            <small class="dashboard-status-button red">{{ $errors->first("description") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.number_of_use') }}</h5>
                        <div class="amount">
                            <input name="number_of_use" type="number" min="1" step="1" class="with-border" placeholder="{{ trans('dash.discounts.number_of_use') }}" value="{{ old('number_of_use', 1) }}">
                        </div>
                        @if($errors->has("amount"))
                            <small class="dashboard-status-button red">{{ $errors->first("amount") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.code') }}</h5>
                        <div class="code">
                            <div class="refresh"></div>
                            <input readonly name="code" class="with-border" placeholder="{{ trans('dash.discounts.code') }}" value="{{ old('code') }}">
                        </div>
                        @if($errors->has("code"))
                            <small class="dashboard-status-button red">{{ $errors->first("code") }}</small>
                        @endif
                    </div>


                    <!----------------------->
                    <!----------------------->
                    <!--- Meghdar takhfif --->
                    <!----------------------->
                    <!----------------------->
                    <!----------------------->

                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.label') }}</h5>

                        <div class="payment">

                            <div class="payment-tab @if( old('haveDiscount' , 0) == 0 ) payment-tab-active @endif">
                                <div class="payment-tab-trigger">
                                    <input @if( old('haveAmount' , 0) == 0 ) checked @endif id="percent" name="haveAmount" type="radio" value="0">
                                    <label for="percent">{{ trans('dash.discounts.percent') }}</label>
                                </div>
                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input class="form-controll" value="{{ old('percent') }}" autocomplete="off" type="text" disabled id="nameOnCard" name="percent" placeholder="{{ trans('dash.discounts.percent_label') }}">
                                                <div class="help-block with-errors"></div>
                                                @if($errors->has("percent"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("percent") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-tab @if( old('haveDiscount') == 1 ) payment-tab-active @endif">
                                <div class="payment-tab-trigger">
                                    <input  @if( old('haveDiscount') == 1 ) checked @endif type="radio" name="haveAmount" id="amount" value="1">
                                    <label for="amount">{{ trans('dash.discounts.amount') }}</label>
                                </div>
                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input class="form-controll" autocomplete="off" type="text" disabled id="nameOnCard" name="amount" placeholder="{{ trans('dash.discounts.amount_label') }}">
                                                <div class="help-block with-errors"></div>
                                                @if($errors->has("amount"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("amount") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-------------------------->
                    <!-------------------------->
                    <!-- end Meghdar takhfif --->
                    <!-------------------------->
                    <!-------------------------->

                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.expired_at') }}</h5>
                        <div class="calender">
                            <div class="body"></div>
                            <input readonly type="hidden" name="expired_at" value="{{ old('expired_at') }}">
                        </div>
                        @if($errors->has("expired_at"))
                            <small class="dashboard-status-button red">{{ $errors->first("expired_at") }}</small>
                        @endif
                    </div>

                    <div class="clearfix"></div>
                    <button class="button ripple-effect move-on-hover full-width margin-top-20">
                        {{ trans('dash.items.create') }}
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        @if($discounts->isNotEmpty())
        <form action="{{ route('dashboard.discount.index') }}" method="GET">
            <div class="input-with-icon">
                <input value="{{ request('s') }}" autocomplete="off" id="autocomplete-input" name="s" placeholder="{{ trans('dash.discounts.search') }}">
                <i class="icon-material-outline-search"></i>
            </div>
        </form>

        <div class="dashboard-box">
            <div class="headline">
                <h3>
                    <i class="icon-material-outline-money"></i>
                    {{ trans('dash.discounts.all') }}
                </h3>
            </div>
            <div class="content">

                <ul class="dashboard-box-list">

                    @foreach($discounts as $discount)
                        <li>
                            <div class="invoice-list-item">
                                <strong class="margin-bottom-10">
                                    {{ $discount->code }}
                                </strong>
                                <ul>

                                    <li>
                                        <span class="{{ $discount->status ? "paid" : "unpaid" }}">{{ trans("dash.status.{$discount->status}") }}</span>
                                    </li>
                                    <li><b>{{ trans('dash.discounts.usage') }}</b> : (<b>{{ $discount->number_of_use . '/' . $discount->payments->count() }}</b>) </li>

                                    @if( $discount->status )
                                        <li>
                                            <b>{{ trans('dash.discounts.how_long') }}</b> :
                                            {{ $discount->expired_at->formatDifference() }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- Buttons -->
                            <div class="buttons-to-left">
                                <a href="{{ route('dashboard.discount.show', $discount->code ) }}" class="button">
                                    {{ trans('dash.discounts.more') }}
                                </a>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>

        {{ $discounts->links('layouts.paginate') }}

        @endif
    </div>

</div>

@stop

@section('plugins')
    <script src="{{ asset('asset/libs/datepicker/datepicker.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('asset/libs/datepicker/datepicker.css') }}">
    <script>
        $(function(){
            $(".calender").each(function () {
                var calender = $(this) ;
                var valField = $("input" , calender ) ;

                if (valField.val().trim() == "")
                    var valField = now() ;
                else
                    var valField = valField.val() ;

                $(".body" , calender ).datepicker({
                    altSecondaryField : $("input" , calender ) ,
                    date : valField ,
                    gregorian : false
                });
            });
        });
    </script>
@stop