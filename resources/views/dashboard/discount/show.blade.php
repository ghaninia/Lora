@extends('dashboard.layouts.master')

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
                        {{ trans('dashboard.discounts.edit') }}
                    </h3>
                </div>
                <div class="content with-padding">

                    <div class="submit-field">
                        <h5>{{ trans('dashboard.items.description') }}</h5>
                        <input name="description" class="with-border" placeholder="{{ trans('dashboard.items.description') }}" value="{{ $discount->description }}">
                        @if($errors->has("description"))
                            <small class="dashboard-status-button red">{{ $errors->first("description") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('dashboard.discounts.number_of_use') }}</h5>
                        <div class="amount">
                            <input name="number_of_use" type="number" min="1" step="1" class="with-border" placeholder="{{ trans('dashboard.discounts.number_of_use') }}" value="{{ $discount->number_of_use }}">
                        </div>
                        @if($errors->has("amount"))
                            <small class="dashboard-status-button red">{{ $errors->first("amount") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('dashboard.discounts.code') }}</h5>
                        <div class="code">
                            <div class="refresh"></div>
                            <input readonly name="code" class="with-border" placeholder="{{ trans('dashboard.discounts.code') }}" value="{{ $discount->code }}">
                        </div>
                        @if($errors->has("code"))
                            <small class="dashboard-status-button red">{{ $errors->first("code") }}</small>
                        @endif
                    </div>

                    <!----------------------->
                    <!--- Meghdar takhfif --->
                    <!----------------------->
                    <div class="submit-field">
                        <h5>{{ trans('dashboard.discounts.label') }}</h5>

                        <div class="payment">

                            @php
                                $haveDiscount = $discount->percent ? 0 : 1 ;
                            @endphp

                            <div class="payment-tab @if( $haveDiscount == 0 ) payment-tab-active @endif">
                                <div class="payment-tab-trigger">
                                    <input @if( $haveDiscount == 0 ) checked @endif id="percent" name="haveAmount" type="radio" value="0">
                                    <label for="percent">{{ trans('dashboard.discounts.percent') }}</label>
                                </div>
                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input class="form-controll" value="{{ $discount->percent ? $discount->percent : null }}" autocomplete="off" type="text" disabled id="nameOnCard" name="percent" placeholder="{{ trans('dashboard.discounts.percent_label') }}">
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
                                        {{ trans('dashboard.discounts.amount') }}
                                        {{ isset($typeCurrency) ? sprintf("(%s)" , $typeCurrency ) : null  }}
                                    </label>
                                </div>

                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input value="{{ $amount }}" class="form-controll" autocomplete="off" type="text" disabled id="nameOnCard" name="amount" placeholder="{{ trans('dashboard.discounts.amount_label') }}">
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
                        <h5>{{ trans('dashboard.discounts.expired_at') }}</h5>
                        <div class="calender">
                            <div class="body"></div>
                            <input readonly type="hidden" name="expired_at" value="{{ $discount->expired_at->datetime()->format("Y-m-d") }}">
                        </div>
                        @if($errors->has("expired_at"))
                            <small class="dashboard-status-button red">{{ $errors->first("expired_at") }}</small>
                        @endif
                    </div>

                    <button class="button full-width margin-top-20">
                        {{ trans('dashboard.discounts.edit_button') }}
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

        <div class="row">
            <div class="col-lg-6">
                <div class="fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>{{ trans('dashboard.discounts.number_of_use') }}</span>
                        <h4>{{ $payments->total() }}</h4>
                    </div>
                    <div class="fun-fact-icon" style="background-color: rgba(54, 189, 120, 0.07);">
                        <i class="icon-material-outline-money" style="color: rgb(54, 189, 120);"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="fun-fact" data-fun-fact-color="#b81b7f">
                    <div class="fun-fact-text">
                        <span>{{ trans('dashboard.items.status') }} :</span>
                        <b>{{ trans("dashboard.status.{$discount->status}") }}</b>
                    </div>
                    <div class="fun-fact-icon" style="background-color: rgba(184, 27, 127, 0.07);"><i class="icon-material-outline-business-center" style="color: rgb(184, 27, 127);"></i></div>
                </div>
            </div>
        </div>

        <table class="table table-padded">
            <thead>
                <tr>
                    @access('factor.payments')
                    <th>{{ trans('dashboard.table.username') }} {{ SortBy('username') }}</th>
                    @endaccess
                    <th>{{ trans('dashboard.table.status') }}</th>
                    <th>{{ trans('dashboard.table.price') }} {{ SortBy('amount') }}</th>
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
                        <span>{{ trans("dashboard.status.payment.{$payment->status}") }}</span>
                    </td>
                    <td class="nowrap bolder">
                        @php( $currency = currency($payment->amount) )
                        <span class="{{ $payment->discount ? "text-danger" : "text-success" }}">{{ sprintf('%s %s' , $currency['currency'] , $currency['type'] ) }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $payments->links('dashboard.layouts.paginate') }}

    </div>

    <!-------------------->
    <!-------------------->
    <!--- end col-lg-5 --->
    <!-------------------->
    <!-------------------->

</div>
@stop
