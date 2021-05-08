@extends('dashboard.layouts.master')
@section('main')
    <div class="dashboard-box">
        <!-- Headline -->
        <div class="headline">
            <h3><i class="icon-material-outline-business-center"></i>{{ trans('dashboard.roles.edit.text_with_attr' , ['attribute' => $role->name ]) }}</h3>
        </div>
        <div class="content">
            <form action="{{ route('dashboard.role.update' , $role->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("put")
                <ul class="fields-ul">
                    <li>
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar-wrapper" data-tippy-placement="bottom" title="{{ trans('dashboard.profile.choose_picture') }}">
                                    <img class="profile-pic" src="{{ picture($role) }}" alt="{{ $role->name }}" />
                                    <div class="upload-button"></div>
                                    <input class="file-upload" type="file" accept="image/*" name="picture"/>
                                </div>
                                @if($errors->has("picture"))
                                    <small class="dashboard-status-button red">{{ $errors->first("picture") }}</small>
                                @endif
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{{ trans('dashboard.items.name') }}</h5>
                                            <input name="name" class="with-border" value="{{ $role->name }}">
                                            @if($errors->has("name"))
                                                <small class="dashboard-status-button red">{{ $errors->first("name") }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{{ trans('dashboard.roles.permissions.text') }}</h5>
                                            @if($permissions->isEmpty())
                                                <div class="notification error closeable">
                                                    <p>{{ trans('dashboard.roles.permissions.without') }}</p>
                                                    <a class="close"></a>
                                                </div>
                                            @else
                                                <select data-selected-text-format="count > 1" class="selectpicker with-border" name="permissions[]" multiple title="{{ trans('dashboard.roles.permissions.desc') }}" data-live-search="true">
                                                    @foreach($permissions as $permission)
                                                        <option value="{{ $permission->id }}" {{ in_array($permission->id , $role_permissions) ? "selected=''" : "" }}>{{ $permission->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                            @if($errors->has("permissions"))
                                                <small class="dashboard-status-button red">{{ $errors->first("permissions") }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="checkbox">
                                            <input type="checkbox" name="default" value="1" id="default" {{ $role->default ? "checked" : "" }}>
                                            <label for="default"><span class="checkbox-icon"></span>{{ trans('dashboard.roles.default.desc') }}</label>
                                            @if($errors->has("default"))
                                                <small class="dashboard-status-button red">{{ $errors->first("default") }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>{{ trans('dashboard.items.description') }}</h5>
                                            <textarea cols="10" rows="2" class="with-border" name="description">{{ $role->description }}</textarea>
                                            @if($errors->has("description"))
                                                <small class="dashboard-status-button red">{{ $errors->first("description") }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <button class="button button-sliding-icon margin-bottom-20">
                                            {{ trans('dashboard.roles.edit.text') }}
                                            <i class="icon-material-outline-arrow-right-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@stop