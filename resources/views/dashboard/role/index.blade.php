@extends('dashboard.layouts.master')
@section('main')
    <div class="notify-box margin-top-15">
        <form action="{{ route('dashboard.role.index') }}">
            <div class="switch-container">
                <label class="switch">
                    <input type="checkbox" name="default" {{ \Request::input('default') == 1 ? "checked" : "" }} value="1" onchange="this.form.submit()">
                    <span class="switch-button"></span>
                    <span class="switch-text">{{ trans('dashboard.roles.just_default') }}</span>
                </label>
            </div>

            <div class="sort-by">
                <span>{{ trans('dashboard.items.sortby') }}:</span>
                <select name="orderBy" class="selectpicker hide-tick" onchange="this.form.submit()">
                    @foreach([ 'id' , 'name' , 'users_count' , 'permissions_count'] as $key )
                        <option value="{{ $key }}" {{ \Request::input('orderBy') == $key ? "selected" : "" }}>{{ trans("dashboard.items.{$key}") }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="listings-container grid-layout margin-top-35">
    @if($roles->isNotEmpty())
        <div class="row">
            @foreach($roles as $role)
                <div class="col-lg-6">
                    <!-- Job Listing -->
                    <div class="job-listing">
                        <!-- Job Listing Details -->
                        <div class="job-listing-details">
                            <!-- Logo -->
                            <div class="job-listing-company-logo">
                                <img src="{{ picture($role , 'thumb') }}" alt="">
                            </div>
                            <!-- Details -->
                            <div class="job-listing-description">
                                <h4 class="job-listing-company">
                                    {{ $role->name }}
                                    @if($role->default)
                                        <span class="verified-badge" title="{{ trans('dashboard.roles.default.text') }}" data-tippy-placement="top"></span>
                                    @endif
                                </h4>
                                <h3 class="job-listing-title">{{ $role->description }}</h3>
                            </div>
                        </div>
                        <!-- Job Listing Footer -->
                        <div class="job-listing-footer">
                        <span class="delete-icon {{ $role->default ? '' :  'deleted' }}"
                              @if(!$role->default)
                              role="swal"
                              href="#"
                              data-message="{{ trans('dashboard.questions.role_delete') }}"
                              data-url="{{ route('dashboard.role.destroy' , $role->id ) }}"
                              data-action="delete"
                              @endif
                              title="{{ trans('dashboard.roles.delete.text') }}"
                              data-tippy-placement="top"
                        >
                        </span>
                            <a title="{{ trans('dashboard.roles.edit.text') }}"
                               data-tippy-placement="top"
                               href="{{ route('dashboard.role.edit' , $role->id) }}" class="edit-icon edited"></a>
                            <ul dir="rtl">
                                <li><i class="icon-material-outline-group"></i>{{ $role->users_count }}</li>
                                <li><i class="icon-material-outline-extension"></i>{{ $role->permissions_count }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    </div>
    <a class="btn--fixed btn--action" href="{{ route('dashboard.role.create') }}" title="{{ trans('dashboard.items.create_new') }}" data-tippy-placement="right">
        <span class="icon-feather-plus"></span>
    </a>
@stop