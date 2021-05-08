@extends('dashboard.layouts.master')
@section('main')
<div class="row">
    <!------------>
    <!--sidebar--->
    <!------------>
    <div class="col-xl-4 col-lg-4">
        <div class="sidebar-container">
            <form action="{{ route('dashboard.user.index') }}">
                <!-- username -->
                <div class="sidebar-widget">
                    <h3>{{ trans('dashboard.profile.username') }}</h3>
                    <div class="input-with-icon">
                        <div id="autocomplete-container">
                            <input autocomplete="off" value="{{ Request::input('username') }}" id="autocomplete-input" name="username" placeholder="{{ trans('dashboard.profile.username') }}">
                        </div>
                        <i class="icon-material-outline-account-circle"></i>
                    </div>
                </div>
                <!-- mobile -->
                <div class="sidebar-widget">
                    <h3>{{ trans('dashboard.profile.mobile') }}</h3>
                    <div class="input-with-icon">
                        <div id="autocomplete-container">
                            <input autocomplete="off" value="{{ Request::input('mobile') }}" id="autocomplete-input" name="mobile" placeholder="{{ trans('dashboard.profile.mobile') }}">
                        </div>
                        <i class="icon-feather-phone"></i>
                    </div>
                </div>
                <!-- email -->
                <div class="sidebar-widget">
                    <h3>{{ trans('dashboard.profile.email') }}</h3>
                    <div class="input-with-icon">
                        <div id="autocomplete-container">
                            <input autocomplete="off" value="{{ Request::input('email') }}" id="autocomplete-input" type="email" name="email" placeholder="{{ trans('dashboard.profile.email') }}">
                        </div>
                        <i class="icon-material-baseline-mail-outline"></i>
                    </div>
                </div>
                <!-- gender -->
                <div class="sidebar-widget">
                    <h3>{{ trans('dashboard.profile.gender') }}</h3>
                    <select class="selectpicker" multiple name="genders[]">
                        @foreach(['male' => 'mdi-male-alt' , 'female' => 'mdi-female' ] as $gender => $icon )
                            <option
                                {{ in_array($gender , Request::input("genders" ,[]) ) ? 'selected' : '' }}
                                value="{{ $gender }}"
                                data-icon="icon-line-awesome-{{ $gender }}">{{ trans("dashboard.profile.genders.$gender") }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- roles -->
                <div class="sidebar-widget">
                    <h3>{{ trans('dashboard.sidebar.roles') }}</h3>
                    <select class="selectpicker" name="roles[]" multiple>
                        @foreach($roles as $role)
                            <option
                                    {{ in_array($role->id , Request::input("roles" ,[]) ) ? 'selected' : '' }}
                                    value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- credit -->
                @if($rangeCreait)
                    @php
                        $min = currency($rangeCreait->min) ;
                        $max = currency($rangeCreait->max) ;
                    @endphp
                    <div class="submit-field margin-top-20">
                        <h5>{{ trans('dashboard.table.credit') }}</h5>
                        <input
                            name="credit"
                            class="range-slider"
                            value=""
                            data-slider-currency="{{ $min['type'] }}"
                            data-slider-min="{{ $min['currency'] }}"
                            data-slider-max="{{ $max['currency'] }}"
                            data-slider-step="{{ stepCurrency() }}"
                            data-slider-value="[ {{ request('credit' , sprintf("%s,%s" , $min['currency'] , $max['currency']) ) }}]"/>
                    </div>
                @endif


                <div class="clearfix"></div>
                <hr>
                <button class=" button button-sliding-icon">
                    {{ trans('dashboard.items.filter') }}
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </button>
            </form>
        </div>
        <div class="clearfix"></div>
    </div>
    <!------------>
    <!--content--->
    <!------------>
    <div class="col-xl-8 col-lg-8">
        <div class="notify-box margin-top-15">
            <form action="{{ route('dashboard.user.index') }}">
                <div class="switch-container">
                    <label class="switch">
                        <input type="checkbox" name="status" {{ \Request::input('status') == 1 ? "checked" : "" }} value="1" onchange="this.form.submit()">
                        <span class="switch-button"></span>
                        <span class="switch-text">{{ trans('dashboard.profile.just_status') }}</span>
                    </label>
                </div>
                <div class="sort-by">
                    <span>{{ trans('dashboard.items.sortby') }}:</span>
                    <select name="orderBy" class="selectpicker hide-tick" onchange="this.form.submit()">
                        @foreach([ 'id' ] as $key )
                            <option value="{{ $key }}" {{ \Request::input('orderBy') == $key ? "selected" : "" }}>{{ trans("dashboard.items.{$key}") }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <!-- Freelancers List Container -->
        <div class="freelancers-container freelancers-grid-layout margin-top-35">
            <div class="row">
            @foreach($users as $user)
               <div class="col-lg-6">
                    <!--Freelancer -->
                <div class="freelancer padding-bottom-0">
                    <!-- Overview -->
                    <div class="freelancer-overview">
                        <div class="freelancer-overview-inner">
                            <span
                                role="swal"
                                href="#"
                                data-message="{{ trans('dashboard.questions.user_delete') }}"
                                data-url="{{ route('dashboard.user.destroy' , $user->username ) }}"
                                data-action="delete"
                                class="delete-icon deleted"
                                title="{{ trans('dashboard.users.delete.text') }}"
                                data-tippy-placement="top">
                            </span>
                            <a title="{{ trans('dashboard.users.edit.text') }}"
                               data-tippy-placement="top"
                               href="{{ route('dashboard.user.edit' , $user->username) }}" class="edit-icon"></a>

                            <!-- Avatar -->
                            <div class="freelancer-avatar">
                                <img src="{{ avatar($user) }}">
                            </div>
                            <!-- Name -->
                            <div class="freelancer-name">
                                <h4>
                                    <a href="{{ route('dashboard.user.edit' , $user->username ) }}">
                                        {{ username($user) }}
                                    </a>
                                </h4>
                                <span class="small">{{ sprintf('%s %s' , $user->firstname , $user->lastname ) }}</span>
                            </div>
                            <ul class="dashboard-task-info margin-bottom-0 pointer">
                                @if(!!$user->role)
                                    <li title="{{ $user->role->name }}" data-tippy-placement="top" data-tippy-theme="light">
                                        <strong><i class="icon-material-outline-business-center"></i></strong>
                                    </li>
                                @endif
                                <li title="{{ trans('dashboard.items.created_at') }} : {{ CreateTime($user) }}" data-tippy-placement="top" data-tippy-theme="light">
                                    <strong><i class="icon-material-outline-access-time"></i></strong>
                                </li>
                                <li title="{{ trans('dashboard.profile.email') }} : {{ $user->email }}" data-tippy-placement="top" data-tippy-theme="light">
                                    <strong><i class="icon-material-outline-email"></i></strong>
                                </li>
                                <li title="{{ trans('dashboard.profile.mobile') }} : {{ $user->mobile }}" data-tippy-placement="top" data-tippy-theme="light">
                                    <strong><i class="icon-feather-phone"></i></strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
               </div>
            @endforeach
            </div>
        </div>
        {{ $users->appends($appends)->links('dashboard.layouts.paginate') }}
    </div>
</div>
<a class="btn--fixed btn--action" href="{{ route('dashboard.user.create') }}" title="{{ trans('dashboard.items.create_new') }}" data-tippy-placement="right">
    <span class="icon-feather-plus"></span>
</a>
@stop