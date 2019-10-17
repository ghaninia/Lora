@extends('dashboard.layouts.master')
@section('main')
    <div class="row">
        <div class="col-lg-6">

            <form id="credit" method="POST" action="{{ route('dashboard.credit.pay') }}">
                @csrf

                <div class="form-group">

                    <div class="section-headline margin-top-25 margin-bottom-12">
                        @php($currecy = config('dashboard.currency') )
                        <h3>{{ trans('dashboard.credit.price') }} <b>({{ trans("dashboard.currency.{$currecy}") }})</b></h3>
                    </div>

                    @php( $min = currency(config('dashboard.min_credit')) )
                    @php( $max = currency(config('dashboard.max_credit')) )

                    <div class="amount">
                        <input
                            min="{{ $min['currency'] }}"
                            max="{{ $max['currency'] }}"
                            type="number"
                            value="{{ old('amount' , $min['currency'] ) }}"
                            step="{{ stepCurrency() }}"
                            autocomplete="off"
                            name="amount"
                            required
                            placeholder="{{ trans('dashboard.credit.placeholder') }}">
                    </div>

                    <div class="help-block with-errors"></div>

                    @if($errors->has("amount"))
                        <small class="dashboard-status-button red">{{ $errors->first("amount") }}</small>
                    @endif

                </div>

                <!-- Payment Methods Accordion -->
                <div class="payment margin-top-20">

                    <div class="payment-tab @if( old('haveDiscount' , 0) == 0 ) payment-tab-active @endif">
                        <div class="payment-tab-trigger">
                            <input @if( old('haveDiscount' , 0) == 0 ) checked @endif id="paypal" name="haveDiscount" type="radio" value="0">
                            <label for="paypal">{{ trans('dashboard.credit.ihavenot_discount') }}</label>
                        </div>
                    </div>

                    <div class="payment-tab @if( old('haveDiscount') == 1 ) payment-tab-active @endif">

                        <div class="payment-tab-trigger">
                            <input  @if( old('haveDiscount') == 1 ) checked @endif type="radio" name="haveDiscount" id="creditCart" value="1">
                            <label for="creditCart">{{ trans('dashboard.credit.ihave_discount') }}</label>
                        </div>

                        <div class="payment-tab-content">
                            <div class="row payment-form-row">
                                <div class="col-md-12">
                                    <div class="card-label form-group">
                                        <input class="form-controll" autocomplete="off" type="text" disabled id="nameOnCard" name="discount" placeholder="{{ trans('dashboard.credit.enterdiscount') }}">
                                        <div class="help-block with-errors"></div>
                                        @if($errors->has("discount"))
                                            <small class="dashboard-status-button red">{{ $errors->first("discount") }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Payment Methods Accordion / End -->
                <button class="button big ripple-effect margin-top-40 margin-bottom-65">{{ trans('dashboard.credit.Paynow') }}</button>

            </form>

        </div>
    </div>
@stop