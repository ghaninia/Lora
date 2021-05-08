@extends('dashboard.layouts.master')
@section('main')
    <div class="notify-box margin-top-15">
        <form action="{{ route('dashboard.permission.index') }}">
            <div class="switch-container">
                <label class="switch">
                    <input type="checkbox" name="default" {{ \Request::input('default') == 1 ? "checked" : "" }} value="1" onchange="this.form.submit()">
                    <span class="switch-button"></span>
                    <span class="switch-text">{{ trans('dashboard.permissions.just_default') }}</span>
                </label>
            </div>

            <div class="sort-by">
                <span>{{ trans('dashboard.items.sortby') }}:</span>
                <select name="orderBy" class="selectpicker hide-tick" onchange="this.form.submit()">
                    @foreach([ 'id' , 'name' , 'roles_count'] as $key )
                        <option value="{{ $key }}" {{ \Request::input('orderBy') == $key ? "selected" : "" }}>{{ trans("dashboard.items.{$key}") }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="attachments-container margin-top-0 margin-bottom-0">
        <div class="row">
            @foreach($permissions as $permission)
                <div class="col-lg-4">
                    <div class="attachment-box row-3 padding-bottom-10">
                        <span>{{ $permission->name }}</span>
                        @if(!!$permission->description)
                            <small class="attachment-box-small">
                                {{ $permission->description }}
                            </small>
                        @endif

                        <button
                                role="swal"
                                data-url="{{ route('dashboard.permission.edit' , $permission->id ) }}"
                                data-action="link"
                                title="{{ trans('dashboard.permissions.edit.text') }}"
                                data-tippy-placement="top"
                                class="edit-attachment">
                        </button>

                        @if(!$permission->default)
                            <button
                                role="swal"
                                data-message="{{ trans('dashboard.questions.permission_delete') }}"
                                data-url="{{ route('dashboard.permission.destroy' , $permission->id ) }}"
                                data-action="delete"
                                title="{{ trans('dashboard.permissions.delete.text') }}"
                                data-tippy-placement="top"
                                class="remove-attachment">
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <a class="btn--fixed btn--action" href="{{ route('dashboard.permission.create') }}" title="{{ trans('dashboard.items.create_new') }}" data-tippy-placement="right">
        <span class="icon-feather-plus"></span>
    </a>
@stop