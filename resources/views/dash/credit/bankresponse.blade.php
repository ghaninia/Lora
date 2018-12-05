@extends('layouts.dash')
@section('main')

    @if(isset($message , $status))
        <div class="notification {{ $status ? "success" : "error" }} closeable">
            <p>{{ $message }}</p>
            <a class="close" href="#"></a>
        </div>
    @endif

    @if(isset($payment))
        <div class="row">
            <div class="col-lg-12">
                <div class="boxed-widget summary margin-top-0">
                    <div class="boxed-widget-headline">
                        <h3>{{ trans('dash.factor.label') }}</h3>
                    </div>
                    <div class="boxed-widget-inner">
                        <ul>

                            @php( $amount = currency($payment->amount) )
                            <li> {{ trans('dash.factor.amount') }} <span> {{ sprintf('%s %s' , $amount['currency'] , $amount['type']) }} </span></li>
                            <li> {{ trans('dash.factor.transaction_id') }} <span>{{ $payment->transaction_id }}</span></li>
                            <li> {{ trans('dash.factor.tracking_code') }} <span>{{ $payment->tracking_code }}</span></li>

                            <li> {{ trans('dash.factor.created_at') }} <span>{{ $payment->created_at->format(config('dash.format_date')) }}</span></li>

                            @if(!! $payment->discount )
                                <li style="overflow: hidden"> {{ trans('dash.factor.coupon') }}
                                    @if( $payment->discount->amount )
                                        @php($discount = currency($payment->discount->amount) )
                                        <span class="dashboard-status-button red">{{ sprintf("%s %s" , $discount['currency'] , $discount['type'] ) }}</span>
                                    @else
                                        <span class="dashboard-status-button red">{{ $payment->discount->percent }} %</span>
                                    @endif
                                </li>
                            @endif

                            @if(!! $payment->discount)
                                @php( $amountPayment = currency($amountPayment) )
                                <li class="total-costs">{{ trans('dash.factor.charge') }}<span>{{ sprintf("%s %s" , $amountPayment['currency'] , $amountPayment['type']) }}</span></li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop