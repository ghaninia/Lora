<div class="col-lg-6">
    <div class="form-group submit-field">
        <h5 for="paginate_size">محدودیت زمانی خرید هر فرد</h5>
        <div class="amount">
            <input
                    min="1"
                    type="number"
                    value="{{ option('limit_buy_time') }}"
                    step="1"
                    autocomplete="off"
                    name="limit_buy_time"
                    required>
        </div>
        @if($errors->has("limit_buy_time"))
            <small class="dashboard-status-button red">{{ $errors->first("limit_buy_time") }}</small>
        @endif
    </div>
    <div class="submit-field padding-top-40  padding-bottom-10" style="overflow: hidden;">
        <div class="checkbox btn-block">
            <input type="checkbox" id="two-step" @if( option("user_can_regsiter") ) checked="" @endif  name="user_can_regsiter" value="1">
            <label for="two-step"><span class="checkbox-icon"></span>هرکسی میتواند در سایتمان نام نویسی کند ؟</label>
        </div>
        @if($errors->has("limit_buy_time"))
            <small class="dashboard-status-button red">{{ $errors->first("limit_buy_time") }}</small>
        @endif
    </div>

    <div class="submit-field">
        <h5>برای کاربران تازه ثبت نام شده چه نقشی اختصاص می یابد ؟</h5>
        <select class="selectpicker with-border" name="user_default_role" title="انتخاب نقش ..." data-live-search="true">
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $role->id == option("user_default_role") ? "selected=''" : "" }}>{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
</div>