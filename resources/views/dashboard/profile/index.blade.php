@extends("dashboard.layouts.master")
@section("main")
    <form action="{{ route('dashboard.profile.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- Row -->
        <div class="row">
            <!-- Dashboard Box -->
            <div class="col-xl-12">
                <div class="dashboard-box margin-top-0">
                    <!-- Headline -->
                    <div class="headline">
                        <h3>
                            @if(\Request::input("index") == "password")
                                <i class="icon-material-outline-lock"></i>
                            @else
                                <i class="icon-material-outline-account-circle"></i>
                            @endif
                            {{ trans("dashboard.profile.edit.text") }}
                        </h3>
                    </div>
                    <div class="content with-padding padding-bottom-0">
                        <div class="row">
                            @if(\Request::input("index") == "password")
                                <input type="hidden" name="type" value="password">
                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>{{ trans("dashboard.profile.password") }}</h5>
                                        <input type="password" autocomplete="off" name="password" id="password" class="with-border {{ $errors->has("password") ? "border-danger" : ""}}">
                                        @if($errors->has("password"))
                                            <small class="dashboard-status-button red">{{ $errors->first("password") }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-12 margin-bottom-20">
                                    <div class="submit-field">
                                        <h5>{{ trans("dashboard.profile.password_confirmation") }}</h5>
                                        <input type="password" autocomplete="off" name="password_confirmation" id="password_confirmation" class="with-border {{ $errors->has("password_confirmation") ? "border-danger" : ""}}">
                                        @if($errors->has("confirmed_password"))
                                            <small class="dashboard-status-button red">{{ $errors->first("password_confirmation") }}</small>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="type" value="profile">
                                <div class="col-auto">
                                    <div class="avatar-wrapper" data-tippy-placement="bottom" title="{{ trans('dashboard.profile.choose_picture') }}">
                                        <img class="profile-pic" src="{{ avatar() }}" alt="" />
                                        <div class="upload-button"></div>
                                        <input class="file-upload" type="file" accept="image/*" name="picture"/>
                                    </div>
                                    @if($errors->has("picture"))
                                        <small class="dashboard-status-button red">{{ $errors->first("picture") }}</small>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ trans("dashboard.profile.firstname") }}</h5>
                                                <input autocomplete="off" name="firstname" id="firstname" class="with-border {{ $errors->has("firstname") ? "border-danger" : ""}}" value="{{ $user->firstname }}">
                                                @if($errors->has("firstname"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("firstname") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ trans("dashboard.profile.lastname") }}</h5>
                                                <input autocomplete="off" name="lastname" id="lastname" class="with-border {{ $errors->has("lastname") ? "border-danger" : ""}}" value="{{ $user->lastname }}">
                                                @if($errors->has("lastname"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("lastname") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ trans("dashboard.profile.username") }}</h5>
                                                <input autocomplete="off" autocomplete="off" name="username" id="username" class="with-border {{ $errors->has("username") ? "border-danger" : ""}}" value="{{ $user->username }}">
                                                @if($errors->has("username"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("username") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ trans("dashboard.profile.email") }}</h5>
                                                <input autocomplete="off" dir="ltr" id="email" name="email" class="with-border {{ $errors->has("email") ? "border-danger" : ""}}" value="{{ $user->email }}">
                                                @if($errors->has("email"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("email") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ trans("dashboard.profile.mobile") }}</h5>
                                                <input autocomplete="off" dir="ltr" name="mobile" id="mobile" class="with-border {{ $errors->has("mobile") ? "border-danger" : ""}}" value="{{ $user->mobile }}">
                                                @if($errors->has("mobile"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("mobile") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="submit-field">
                                                <h5>{{ trans("dashboard.profile.theme") }}</h5>
                                                <select name="theme" class="selectpicker with-border" data-size="7" title="{{ trans('dashboard.profile.select_one_color') }}" data-live-search="true">
                                                    @foreach(['red' , 'yellow' , 'green' , 'blue'] as $value)
                                                        <option @if($user->theme == $value ) selected @endif value="{{ $value }}">{{ trans("dashboard.profile.themes.{$value}") }}</option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has("theme"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("theme") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <!-- Account Type -->
                                            <div class="submit-field">
                                                <h5>{{ trans("dashboard.profile.gender") }}</h5>
                                                <div class="account-type">
                                                    @foreach(['male' => 'mdi-male-alt' , 'female' => 'mdi-female' ] as $gender => $icon )
                                                        <div>
                                                            <input type="radio" name="gender" value="{{ $gender }}" id="{{ $gender }}-radio" class="account-type-radio" @if($user->gender == $gender ) checked @endif />
                                                            <label for="{{ $gender }}-radio" class="ripple-effect-dark">{{ trans("dashboard.profile.genders.$gender") }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if($errors->has("gender"))
                                                    <small class="dashboard-status-button red">{{ $errors->first("gender") }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <button class=" button button-sliding-icon margin-top-20">
                    {{ trans("dashboard.profile.edit.text") }}
                    <i class="icon-material-outline-arrow-right-alt"></i>
                </button>
            </div>
        </div>
    </form>
@stop
