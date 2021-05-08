<div class="col-lg-6">
    <div class="form-group submit-field">
        <h5 for="min_credit">حداقل میزان شارژ کیف پول (ریال)</h5>
        <div class="amount">
            <input
                    min="1"
                    type="number"
                    value="{{ option('min_credit') }}"
                    step="10000"
                    autocomplete="off"
                    name="min_credit"
                    required>
        </div>
        @if($errors->has("min_credit"))
            <small class="dashboard-status-button red">{{ $errors->first("min_credit") }}</small>
        @endif
    </div>

    <div class="form-group submit-field">
        <h5 for="max_credit">حداکثر میزان شارژ کیف پول (ریال)</h5>
        <div class="amount">
            <input
                    min="1"
                    type="number"
                    value="{{ option('max_credit') }}"
                    step="10000"
                    autocomplete="off"
                    name="max_credit"
                    required>
        </div>
        @if($errors->has("max_credit"))
            <small class="dashboard-status-button red">{{ $errors->first("max_credit") }}</small>
        @endif
    </div>
</div>