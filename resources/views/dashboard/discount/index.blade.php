@extends('dashboard.layouts.master')

@section('main')

<div class="row">

    <div class="col-lg-5">
        <div class="dashboard-box margin-top-0">

            <!-- Headline -->
            <div class="headline">
                <h3>
                    {{ trans('lora.discounts.create') }}
                </h3>
            </div>

            <div class="content with-padding">
                <form action="{{ route('dashboard.discount.store') }}" method="POST">
                    @csrf

                    <div class="submit-field">
                        <h5>{{ trans('lora.items.description') }}</h5>
                        <input name="description" class="with-border" placeholder="{{ trans('lora.items.description') }}" value="{{ old('description') }}">
                        @if($errors->has("description"))
                            <small class="dashboard-status-button red">{{ $errors->first("description") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('lora.discounts.number_of_use') }}</h5>
                        <div class="amount">
                            <input name="number_of_use" type="number" min="1" step="1" class="with-border" placeholder="{{ trans('lora.discounts.number_of_use') }}" value="{{ old('number_of_use', 1) }}">
                        </div>
                        @if($errors->has("amount"))
                            <small class="dashboard-status-button red">{{ $errors->first("amount") }}</small>
                        @endif
                    </div>

                    <div class="submit-field">
                        <h5>{{ trans('lora.discounts.code') }}</h5>
                        <div class="code">
                            <div class="refresh"></div>
                            <input readonly name="code" class="with-border" placeholder="{{ trans('lora.discounts.code') }}" value="{{ old('code') }}">
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
                        <h5>{{ trans('lora.discounts.label') }}</h5>

                        <div class="payment">

                            <div class="payment-tab @if( old('haveDiscount' , 0) == 0 ) payment-tab-active @endif">
                                <div class="payment-tab-trigger">
                                    <input @if( old('haveAmount' , 0) == 0 ) checked @endif id="percent" name="haveAmount" type="radio" value="0">
                                    <label for="percent">{{ trans('lora.discounts.percent') }}</label>
                                </div>
                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input class="form-controll" value="{{ old('percent') }}" autocomplete="off" type="text" disabled id="nameOnCard" name="percent" placeholder="{{ trans('lora.discounts.percent_label') }}">
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
                                    <label for="amount">{{ trans('lora.discounts.amount') }}</label>
                                </div>
                                <div class="payment-tab-content">
                                    <div class="row payment-form-row">
                                        <div class="col-md-12">
                                            <div class="card-label form-group">
                                                <input class="form-controll" autocomplete="off" type="text" disabled id="nameOnCard" name="amount" placeholder="{{ trans('lora.discounts.amount_label') }}">
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
                        <h5>{{ trans('lora.discounts.expired_at') }}</h5>
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
                        {{ trans('lora.items.create') }}
                    </button>

                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        @if($discounts->isNotEmpty())
        <form action="{{ route('dashboard.discount.index') }}" method="GET">
            <div class="input-with-icon">
                <input value="{{ request('s') }}" autocomplete="off" id="autocomplete-input" name="s" placeholder="{{ trans('lora.discounts.search') }}">
                <i class="icon-material-outline-search"></i>
            </div>
        </form>

        <div class="dashboard-box">
            <div class="headline">
                <h3>
                    <i class="icon-material-outline-money"></i>
                    {{ trans('lora.discounts.all') }}
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
                                        <span class="{{ $discount->status ? "paid" : "unpaid" }}">{{ trans("lora.status.{$discount->status}") }}</span>
                                    </li>
                                    <li><b>{{ trans('lora.discounts.usage') }}</b> : (<b>{{ $discount->number_of_use . '/' . $discount->payments->count() }}</b>) </li>

                                    @if( $discount->status )
                                        <li>
                                            <b>{{ trans('lora.discounts.how_long') }}</b> :
                                            {{ $discount->expired_at->formatDifference() }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- Buttons -->
                            <div class="buttons-to-left">
                                <a href="{{ route('dashboard.discount.show', $discount->code ) }}" class="button">
                                    {{ trans('lora.discounts.more') }}
                                </a>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>

        {{ $discounts->links('dashboard.layouts.paginate') }}
        @endif
    </div>
</div>
@stop
