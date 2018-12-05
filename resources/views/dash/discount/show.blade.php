@extends('layouts.dash')

@section('main')
<div class="row">

    <div class="col-lg-5">
        <div class="dashboard-box margin-top-0">
            <form action="{{ route('dashboard.discount.update' , ['discount' => $discount->code ]) }}" method="POST">
            @csrf
            @method("PUT")
                <!-- Headline -->
                <div class="headline">
                    <h3>
                        {{ trans('dash.discounts.edit') }}
                    </h3>
                </div>
                <div class="content with-padding">

                    <div class="submit-field">
                        <h5>{{ trans('dash.items.description') }}</h5>
                        <input name="description" class="with-border" placeholder="{{ trans('dash.items.description') }}" value="{{ $discount->description }}">
                        @if($errors->has("description"))
                            <small class="dashboard-status-button red">{{ $errors->first("description") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.number_of_use') }}</h5>
                        <div class="amount">
                            <input name="number_of_use" type="number" min="1" step="1" class="with-border" placeholder="{{ trans('dash.discounts.number_of_use') }}" value="{{ $discount->number_of_use }}">
                        </div>
                        @if($errors->has("amount"))
                            <small class="dashboard-status-button red">{{ $errors->first("amount") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.code') }}</h5>
                        <div class="code">
                            <div class="refresh"></div>
                            <input readonly name="code" class="with-border" placeholder="{{ trans('dash.discounts.code') }}" value="{{ $discount->code }}">
                        </div>
                        @if($errors->has("code"))
                            <small class="dashboard-status-button red">{{ $errors->first("code") }}</small>
                        @endif
                    </div>

                    <!----------------------->
                    <!--- Meghdar takhfif --->
                    <!----------------------->
                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.label') }}</h5>

                        <div class="payment">

                            @php
                                $haveDiscount = $discount->percent ? 0 : 1 ;
                            @endphp

                            <div class="payment-tab @if( $haveDiscount == 0 ) payment-tab-active @endif">
                                <div class="payment-tab-trigger">
                                    <input @if( $haveDiscount == 0 ) checked @endif id="percent" name="haveAmount" type="radio" value="0">
                                    <label for="percent">{{ trans('dash.discounts.percent') }}</label>
                                </div>
                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input class="form-controll" value="{{ $discount->percent ? $discount->percent : null }}" autocomplete="off" type="text" disabled id="nameOnCard" name="percent" placeholder="{{ trans('dash.discounts.percent_label') }}">
                                                <div class="help-block with-errors"></div>
                                                @if($errors->has("percent"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("percent") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="payment-tab @if( $haveDiscount == 1 ) payment-tab-active @endif">
                                @php
                                    $amount = $discount->amount ;
                                    if($amount > 0)
                                    {
                                        $currency = currency($discount->amount);
                                        $amount   = $currency['currency'] ;
                                        $typeCurrency = $currency['type'] ;
                                    }else{
                                        $amount = null ;
                                    }
                                @endphp
                                <div class="payment-tab-trigger">
                                    <input  @if( $haveDiscount == 1 ) checked @endif type="radio" name="haveAmount" id="amount" value="1">
                                    <label for="amount">
                                        {{ trans('dash.discounts.amount') }}
                                        {{ isset($typeCurrency) ? sprintf("(%s)" , $typeCurrency ) : null  }}
                                    </label>
                                </div>

                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input value="{{ $amount }}" class="form-controll" autocomplete="off" type="text" disabled id="nameOnCard" name="amount" placeholder="{{ trans('dash.discounts.amount_label') }}">
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
                    <!-- end Meghdar takhfif --->
                    <!-------------------------->
                    <div class="submit-field">
                        <h5>{{ trans('dash.discounts.expired_at') }}</h5>
                        <div class="calender">
                            <div class="body"></div>
                            <input readonly type="hidden" name="expired_at" value="{{ $discount->expired_at->datetime()->format("Y-m-d") }}">
                        </div>
                        @if($errors->has("expired_at"))
                            <small class="dashboard-status-button red">{{ $errors->first("expired_at") }}</small>
                        @endif
                    </div>

                    <button class="button full-width margin-top-20">
                        {{ trans('dash.discounts.edit_button') }}
                    </button>

                </div>

            </form>
        </div>
    </div>

    <!-------------------->
    <!-------------------->
    <!--- end col-lg-5 --->
    <!-------------------->
    <!-------------------->

    <div class="col-lg-7">

        <div class="fun-facts-container margin-bottom-10">
            <div class="fun-fact" data-fun-fact-color="#36bd78">
                <div class="fun-fact-text">
                    <span>{{ trans('dash.discounts.number_of_use') }}</span>
                    <h4>{{ $payments->total() }}</h4>
                </div>
                <div class="fun-fact-icon" style="background-color: rgba(54, 189, 120, 0.07);">
                    <i class="icon-material-outline-money" style="color: rgb(54, 189, 120);"></i>
                </div>
            </div>
            <div class="fun-fact" data-fun-fact-color="#b81b7f">
                <div class="fun-fact-text">
                    <span>{{ trans('dash.items.status') }} :</span>
                    <b>{{ trans("dash.status.{$discount->status}") }}</b>
                </div>
                <div class="fun-fact-icon" style="background-color: rgba(184, 27, 127, 0.07);"><i class="icon-material-outline-business-center" style="color: rgb(184, 27, 127);"></i></div>
            </div>
        </div>

        <table class="table table-padded">
            <thead>
                <tr>
                    @access('factor.payments')
                    <th>{{ trans('dash.table.username') }} {{ SortBy('username') }}</th>
                    @endaccess
                    <th>{{ trans('dash.table.status') }}</th>
                    <th>{{ trans('dash.table.price') }} {{ SortBy('amount') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($payments as $payment)
                <tr>
                    @access('factor.payments')
                    <td class="nowrap" title="{{ $payment->created_at->format("Y/m/d H:i") }}" data-tippy-placement="left">
                        <a href="{{ QueryBuilderHeader('username' , $payment->username) }}">{{ $payment->username }}</a>
                    </td>
                    @endaccess
                    <td class="nowrap">
                        @switch( $payment->status )
                        @case (\Larabookir\Gateway\Enum::TRANSACTION_INIT)
                        <span class="status-pill yellow"></span>
                        @break
                        @case (\Larabookir\Gateway\Enum::TRANSACTION_FAILED)
                        <span class="status-pill red"></span>
                        @break
                        @case (\Larabookir\Gateway\Enum::TRANSACTION_SUCCEED)
                        <span class="status-pill green"></span>
                        @break
                        @endswitch
                        <span>{{ trans("dash.status.payment.{$payment->status}") }}</span>
                    </td>
                    <td class="nowrap bolder">
                        @php( $currency = currency($payment->amount) )
                        <span class="{{ $payment->discount ? "text-danger" : "text-success" }}">{{ sprintf('%s %s' , $currency['currency'] , $currency['type'] ) }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $payments->links('layouts.paginate') }}

    </div>

    <!-------------------->
    <!-------------------->
    <!--- end col-lg-5 --->
    <!-------------------->
    <!-------------------->

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