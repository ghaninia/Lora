@extends('dashboard.layouts.master')
@section('main')
    <div class="messages-container margin-top-0" id="message">

        <div class="messages-container-inner">

            <!-- Messages -->
            <div class="messages-inbox">
                <div class="messages-headline">
                    <div class="input-with-icon">
                        <input id="search" type="text" placeholder="{{ trans('dashboard.items.search_trakingcode') }}">
                        <i class="icon-material-outline-search"></i>
                    </div>
                </div>
                <div class="append" id="append">
                    <i class="icon icon-feather-plus"></i>
                    <span>{{ trans('dashboard.tickets.append') }}</span>
                </div>
                <ul id="side">
                    {!! $side !!}
                </ul>
            </div>
            <!-- Messages / End -->

            <!-- Message Content -->
            <div class="message-content" id="content">
            </div>
            <!-- Message Content -->

        </div>
    </div>
    <!-- Messages Container / End -->
@stop