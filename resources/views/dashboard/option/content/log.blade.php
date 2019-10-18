<div class="col-lg-6">
    <div class="submit-field">
        <h5>پست الکترونیک برای ارسال لاگ</h5>
        <input dir="auto" name="log_email" type="email" class="with-border" value="{{ option("log_email") }}">
        @if($errors->has("log_email"))
            <small class="dashboard-status-button red">{{ $errors->first("log_email") }}</small>
        @endif
    </div>
</div>