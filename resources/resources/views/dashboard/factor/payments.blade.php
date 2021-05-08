@extends('dashboard.layouts.master')
@section('main')

<div class="row">

    <!---- col-lg-12 ---->
    <!--- filter data --->
    <!------------------->
    <!------------------->
    <div class="col-lg-12">
        <div class="notify-box margin-bottom-15">
            <form action="{{ route('dashboard.factor.payments') }}">
                <div class="row">

                    <div class="col-lg-3">
                        <div class="submit-field">
                            <h5>{{ trans('dashboard.table.username') }}</h5>
                            <input class="{{ $errors->has('username') ? 'border-danger' : null }}" autocomplete="off" name="username" value="{{ request('username') }}">
                        </div>
                        <div class="submit-field">
                            <h5>{{ trans('dashboard.table.status') }}</h5>
                            <select class="selectpicker margin-top-0" name="status">
                                <option value="">{{ trans('dashboard.items.select_one_type') }}</option>
                                @foreach($statusPayment as $status)
                                    <option @if( request('status') == $status) selected @endif value="{{ $status }}">{{ trans("dashboard.status.payment.{$status}") }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="submit-field">
                            <h5>{{ trans('dashboard.table.transaction_id') }}</h5>
                            <input class="{{ $errors->has('username') ? 'border-danger' : null }}" name="transaction_id" autocomplete="off" value="{{ request('transaction_id') }}">
                        </div>

                        <div class="submit-field">
                            <h5>{{ trans('dashboard.table.created_at') }}</h5>
                            <select name="period_time" class="selectpicker  margin-top-0">
                                @foreach(PeriodDate() as $item)
                                    <option @if( request('period_time') == $item) selected @endif value="{{ $item }}">{{ trans("dashboard.period_time.{$item}") }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="submit-field">
                            <h5>{{ trans('dashboard.table.tracking_code') }}</h5>
                            <input class="{{ $errors->has('username') ? 'border-danger' : null }}" name="tracking_code" autocomplete="off" value="{{ request('tracking_code') }}">
                        </div>
                        @if(!! $rangeCreait)
                            @php
                                $min = currency($rangeCreait->min) ;
                                $max = currency($rangeCreait->max) ;
                            @endphp
                            <div class="submit-field margin-top-20">
                                <h5>{{ trans('dashboard.table.price') }}</h5>
                                <input
                                    name="amount"
                                    class="range-slider"
                                    value=""
                                    data-slider-currency="{{ $min['type'] }}"
                                    data-slider-min="{{ $min['currency'] }}"
                                    data-slider-max="{{ $max['currency'] }}"
                                    data-slider-step="{{ stepCurrency() }}"
                                    data-slider-value="[ {{ request('amount' , sprintf("%s,%s" , $min['currency'] , $max['currency']) ) }}]"/>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-3">
                        <div class="submit-field">
                            <h5>{{ trans('dashboard.table.discount_code') }}</h5>
                            <input class="{{ $errors->has('username') ? 'border-danger' : null }}" name="discount_code" autocomplete="off" value="{{ request('discount_code') }}">
                        </div>
                        <button class="button ripple-effect move-on-hover full-width margin-top-55">
                            <span>{{ trans('dashboard.table.filter_payments') }}</span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!---------------------->
    <!--- end filter data--->
    <!---------------------->
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-padded">
                <thead>
                    <tr>
                        @access('factor.payments')
                            <th>{{ trans('dashboard.table.username') }} {{ SortBy('username') }}</th>
                        @endaccess
                        <th>{{ trans('dashboard.table.status') }}</th>
                        <th>{{ trans('dashboard.table.discount_code') }}</th>
                        <th class=" text-center">{{ trans('dashboard.table.transaction_id') }}</th>
                        <th class="text-center">{{ trans('dashboard.table.tracking_code') }}</th>
                        <th>{{ trans('dashboard.table.created_at') }} {{ SortBy('created_at') }}</th>
                        <th>{{ trans('dashboard.table.price') }} {{ SortBy('amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            @access('factor.payments')
                                <td class="nowrap">
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
                                <span>{{ trans("dashboard.status.payment.{$payment->status}") }}</span>
                            </td>
                            <td class="nowrap smaller">
                                @access("discount")
                                    <span><a href="{{ QueryBuilderHeader('discount_code' , $payment->code) }}">{{ $payment->code }}</a></span>
                                @else
                                    <span>{{ $payment->code }}</span>
                                @endaccess
                            </td>
                            <td class="nowrap text-center smaller">
                                <span>{{ $payment->transaction_id }}</span>
                            </td>
                            <td class="nowrap text-center smaller">
                                <span>{{ $payment->tracking_code }}</span>
                            </td>
                            <td>
                                <span>{{ $payment->created_at->format("H:i") }}</span>
                                <span class="smaller lighter">{{ $payment->created_at->format( config('dashboard.format_date') ) }}</span>
                            </td>
                            <td class="nowrap bolder">
                                @php( $currency = currency($payment->amount) )
                                <span class="{{ $payment->discount ? "text-danger" : "text-success" }}">{{ sprintf('%s %s' , $currency['currency'] , $currency['type'] ) }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $payments->links('dashboard.layouts.paginate') }}

    </div>

</div>
@stop

