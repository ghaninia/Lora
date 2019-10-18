<div class="col-auto">
    <div class="avatar-wrapper" data-tippy-placement="bottom" title="انتخاب لوگو">
        <img class="profile-pic" src="{{ logo("full") }}"/>
        <div class="upload-button"></div>
        <input class="file-upload" type="file" name="site_logo" accept="image/*"/>
    </div>
    @if($errors->has("site_logo"))
        <small class="dashboard-status-button red">{{ $errors->first("site_logo") }}</small>
    @endif
    <div class="avatar-wrapper" data-tippy-placement="bottom" title="انتخاب فاوآیکون">
        <img class="profile-pic" src="{{ favicon() }}"/>
        <div class="upload-button"></div>
        <input class="file-upload" type="file" name="site_favicon"  accept="image/*"/>
    </div>
    @if($errors->has("site_favicon"))
        <small class="dashboard-status-button red">{{ $errors->first("site_favicon") }}</small>
    @endif
    <div class="avatar-wrapper" data-tippy-placement="bottom" title="انتخاب عکس جایگزین">
        <img class="profile-pic" src="{{ preview("full") }}"/>
        <div class="upload-button"></div>
        <input class="file-upload" type="file" name="site_perview"  accept="image/*"/>
    </div>
    @if($errors->has("site_perview"))
        <small class="dashboard-status-button red">{{ $errors->first("site_perview") }}</small>
    @endif
</div>
<div class="col">
    <div class="submit-field">
        <h5>نام سایت</h5>
        <input name="site_title" type="text" class="with-border" value="{{ option("site_title") }}">
        @if($errors->has("site_title"))
            <small class="dashboard-status-button red">{{ $errors->first("site_title") }}</small>
        @endif
    </div>
    <div class="submit-field">
        <h5>درباره ی سایت</h5>
        <textarea name="site_description" rows="1" class="with-border">{{ option("site_description") }}</textarea>
        @if($errors->has("site_description"))
            <small class="dashboard-status-button red">{{ $errors->first("site_description") }}</small>
        @endif
    </div>
    <div class="submit-field">
        <h5>کپی رایت سایت</h5>
        <textarea name="site_copyright" rows="1" class="with-border">{{ option("site_copyright") }}</textarea>
        @if($errors->has("site_copyright"))
            <small class="dashboard-status-button red">{{ $errors->first("site_copyright") }}</small>
        @endif
    </div>
    <div class="submit-field">
        <h5> آدرس سایت</h5>
        <textarea name="site_address" rows="1" class="with-border">{{ option("site_address") }}</textarea>
        @if($errors->has("site_address"))
            <small class="dashboard-status-button red">{{ $errors->first("site_address") }}</small>
        @endif
    </div>
    <div class="submit-field">
        <h5>تلفن سایت</h5>
        <input name="site_tellphone" type="text" dir="ltr"  class="with-border" value="{{ option("site_tellphone") }}">
        @if($errors->has("site_tellphone"))
            <small class="dashboard-status-button red">{{ $errors->first("site_tellphone") }}</small>
        @endif
    </div>
    <div class="submit-field">
        <h5>ایمیل سایت</h5>
        <input name="site_email" type="email" dir="ltr" class="with-border" value="{{ option("site_email") }}">
        @if($errors->has("site_email"))
            <small class="dashboard-status-button red">{{ $errors->first("site_email") }}</small>
        @endif
    </div>
    <div class="keywords-container submit-field"  style="overflow: hidden"  data-name="keywords" data-max="20">
        <h5>
            کلمات کلیدی سایت
            <i class="help-icon" data-tippy-placement="top" title="برای سایت خود کلمه کلیدی تعیین کنید."></i>
        </h5>
        <div class="keyword-input-container">
            <div class="form-group">
                <input placeholder="کلمات کلیدی سایت" class="{{ $errors->has('keywords') ? 'border-danger' : null }} keyword-input form-control"/>
            </div>
            <button type="button" class="keyword-input-button btn-primary"><i class="icon-material-outline-add"></i></button>
        </div>

        <div class="keywords-list">
            @if( keywords() )
                @foreach( keywords() as $keyword)
                    <span class='keyword'>
                                                    <span class='keyword-remove'></span>
                                                    <input checked class='hidden' type='checkbox' name='keywords[]' multiple value='{{ $keyword }}' />
                                                    <span class='keyword-text'>{{ $keyword }}</span>
                                                </span>
                @endforeach
            @endif
        </div>
        @if($errors->has("keywords"))
            <small class="dashboard-status-button red">{{ $errors->first("keywords") }}</small>
        @endif
    </div>
    <div class="form-group submit-field">
        <h5 for="paginate_size">تعداد آیتم ها در صفحه بندی</h5>
        <div class="amount">
            <input
                    min="1"
                    type="number"
                    value="{{ option('paginate_size') }}"
                    step="1"
                    autocomplete="off"
                    name="paginate_size"
                    required>
        </div>
        @if($errors->has("paginate_size"))
            <small class="dashboard-status-button red">{{ $errors->first("paginate_size") }}</small>
        @endif
    </div>
</div>