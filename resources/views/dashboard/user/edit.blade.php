@extends("dashboard.layouts.master")
@section("main")
<!-- Row -->
<div class="row">
    <!-- Dashboard Box -->
    <div class="col-xl-8">
        <form action="{{ route('dashboard.user.update' , $user->username ) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method("put")
            <div class="dashboard-box margin-top-0">
                <!-- Headline -->
                <div class="headline">
                    <h3>
                        @if(\Request::input("index") == "password")
                            <i class="icon-material-outline-lock"></i>
                        @else
                            <i class="icon-material-outline-account-circle"></i>
                        @endif
                        {{ trans('dashboard.users.edit.text') }}
                    </h3>
                </div>
                <div class="content with-padding padding-bottom-0">
                    <div class="row">
                        <input type="hidden" name="type" value="profile">
                        <div class="col-auto">
                            <div class="avatar-wrapper" data-tippy-placement="bottom" title="{{ trans('dashboard.profile.choose_picture') }}">
                                <img class="profile-pic" src="{{ avatar($user) }}" alt="" />
                                <div class="upload-button"></div>
                                <input class="file-upload" type="file" accept="image/*" name="picture"/>
                            </div>
                            @if($errors->has("picture"))
                                <small class="dashboard-status-button red">{{ $errors->first("picture") }}</small>
                            @endif
                        </div>
                        <div class="col">
                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.firstname") }}</h5>
                                <input autocomplete="off" name="firstname" id="firstname" class="with-border {{ $errors->has("firstname") ? "border-danger" : ""}}" value="{{ $user->firstname }}">
                                @if($errors->has("firstname"))
                                    <small class="dashboard-status-button red">{{ $errors->first("firstname") }}</small>
                                @endif
                            </div>

                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.lastname") }}</h5>
                                <input autocomplete="off" name="lastname" id="lastname" class="with-border {{ $errors->has("lastname") ? "border-danger" : ""}}" value="{{ $user->lastname }}">
                                @if($errors->has("lastname"))
                                    <small class="dashboard-status-button red">{{ $errors->first("lastname") }}</small>
                                @endif
                            </div>

                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.username") }}</h5>
                                <input autocomplete="off"  name="username" id="username" class="with-border {{ $errors->has("username") ? "border-danger" : ""}}" value="{{ $user->username }}">
                                @if($errors->has("username"))
                                    <small class="dashboard-status-button red">{{ $errors->first("username") }}</small>
                                @endif
                            </div>

                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.email") }}</h5>
                                <input autocomplete="off" dir="ltr" id="email" name="email" class="with-border {{ $errors->has("email") ? "border-danger" : ""}}" value="{{ $user->email }}">
                                @if($errors->has("email"))
                                    <small class="dashboard-status-button red">{{ $errors->first("email") }}</small>
                                @endif
                            </div>

                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.mobile") }}</h5>
                                <input autocomplete="off" dir="ltr" name="mobile" id="mobile" class="with-border {{ $errors->has("mobile") ? "border-danger" : ""}}" value="{{ $user->mobile }}">
                                @if($errors->has("mobile"))
                                    <small class="dashboard-status-button red">{{ $errors->first("mobile") }}</small>
                                @endif
                            </div>

                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.role") }}</h5>
                                <select name="role_id" class="selectpicker with-border" data-size="7" title="{{ trans('dashboard.profile.select_one_role') }}" data-live-search="true">
                                    @foreach($roles as $role)
                                        <option @if($role->id == $user->role_id ) selected @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has("role_id"))
                                    <small class="dashboard-status-button red">{{ $errors->first("role_id") }}</small>
                                @endif
                            </div>

                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.theme") }}</h5>
                                <select name="theme" class="selectpicker with-border" data-size="7" title="{{ trans('dashboard.items.select_one_type') }}" data-live-search="true">
                                    @foreach(['red' , 'yellow' , 'green' , 'blue'] as $value)
                                        <option @if($user->theme == $value ) selected @endif value="{{ $value }}">{{ trans("dashboard.profile.themes.{$value}") }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has("theme"))
                                    <small class="dashboard-status-button red">{{ $errors->first("theme") }}</small>
                                @endif
                            </div>

                            <div class="submit-field">
                                <h5>{{ trans("dashboard.profile.gender") }}</h5>
                                <div class="account-type">
                                    @foreach(['male' => 'mdi-male-alt' , 'female' => 'mdi-female' ] as $gender => $icon )
                                        <div>
                                            <input type="radio" name="gender" value="{{ $gender }}" id="{{ $gender }}-radio" class="account-type-radio" @if($user->gender == $gender ) checked @endif />
                                            <label for="{{ $gender }}-radio" class="ripple-effect-dark"><i class="icon-line-awesome-{{ $gender }}"></i>{{ trans("dashboard.profile.genders.$gender") }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @if($errors->has("gender"))
                                    <small class="dashboard-status-button red">{{ $errors->first("gender") }}</small>
                                @endif
                            </div>

                            <div class="padding-bottom-20 pointer">
                                <label class="text-black">
                                        <div class="checkbox" style="position: relative;top:-5px">
                                            <input name="status" type="checkbox" value="1" id="status-checkbox" @if($user->status) checked @endif>
                                            <label for="status-checkbox"><span class="checkbox-icon"></span></label>
                                        </div>
                                    {{ trans("dashboard.profile.status.text") }}
                                    <i class="help-icon" data-tippy-placement="top" title="{{ trans("dashboard.profile.status.desc") }}"></i>
                                </label>
                                @if($errors->has("status"))
                                    <small class="dashboard-status-button red">{{ $errors->first("status") }}</small>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <button class="button button-sliding-icon margin-top-20 margin-bottom-20">
                {{ trans('dashboard.users.edit.text') }}
                <i class="icon-material-outline-arrow-right-alt"></i>
            </button>
        </form>
    </div>

    <div class="col-xl-4">
        <form action="{{ route('dashboard.user.update' , $user->username ) }}" method="post">
            @csrf
            @method("put")
            <input type="hidden" name="type" value="password">

            <div class="sidebar-widget">
                <h3>{{ trans("dashboard.profile.password") }}</h3>
                <div class="input-with-icon">
                    <div id="autocomplete-container">
                        <input type="password" autocomplete="off" name="password" id="password" class="with-border {{ $errors->has("password") ? "border-danger" : ""}}">
                    </div>
                    <i class="icon-material-outline-lock"></i>
                </div>
                @if($errors->has("password"))
                    <small class="dashboard-status-button red">{{ $errors->first("password") }}</small>
                @endif
            </div>

            <div class="sidebar-widget">
                <h3>{{ trans("dashboard.profile.password_confirmation") }}</h3>
                <div class="input-with-icon">
                    <div id="autocomplete-container">
                        <input type="password" autocomplete="off" name="password_confirmation" id="password_confirmation" class="with-border {{ $errors->has("password_confirmation") ? "border-danger" : ""}}">
                    </div>
                    <i class="icon-material-outline-lock-open"></i>
                </div>
                @if($errors->has("confirmed_password"))
                    <small class="dashboard-status-button red">{{ $errors->first("password_confirmation") }}</small>
                @endif
            </div>

            <button class="button button-sliding-icon">
                {{ trans('dashboard.profile.changepassword.text') }}
                <i class="icon-material-outline-arrow-right-alt"></i>
            </button>
        </form>
    </div>
</div>
@stop
