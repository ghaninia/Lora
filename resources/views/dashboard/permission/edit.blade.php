@extends('dashboard.layouts.master')
@section('main')
    <div class="dashboard-box">
        <!-- Headline -->
        <div class="headline">
            <h3><i class="icon-material-outline-extension"></i>{{ trans('dashboard.permissions.edit.text_with_attr' , ['attribute' => $permission->name ]) }}</h3>
        </div>
        <div class="content">
            <form action="{{ route('dashboard.permission.update' , $permission->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("put")
                <ul class="fields-ul">
                    <li>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>{{ trans('dashboard.items.name') }}</h5>
                                    <input @if($permission->default) disabled @endif name="name" class="with-border" value="{{ $permission->name }}">
                                    @if($errors->has("name"))
                                        <small class="dashboard-status-button red">{{ $errors->first("name") }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkbox">
                                    <input type="checkbox" name="default" value="1" id="default" {{ $permission->default ? "checked" : "" }}>
                                    <label for="default"><span class="checkbox-icon"></span>{{ trans('dashboard.permissions.default.desc') }}</label>
                                    @if($errors->has("default"))
                                        <small class="dashboard-status-button red">{{ $errors->first("default") }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>{{ trans('dashboard.items.description') }}</h5>
                                    <textarea cols="10" rows="2" class="with-border" name="description">{{ $permission->description }}</textarea>
                                    @if($errors->has("description"))
                                        <small class="dashboard-status-button red">{{ $errors->first("description") }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <button class="button button-sliding-icon margin-bottom-20">
                                    {{ trans('dashboard.permissions.edit.text') }}
                                    <i class="icon-material-outline-arrow-right-alt"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
@stop