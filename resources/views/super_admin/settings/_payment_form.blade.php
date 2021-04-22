<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.paypal_settings') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group required">
                        <label for="paypal_username">{{ __('messages.username') }}</label>
                        <input name="paypal_username" type="text" class="form-control" placeholder="{{ __('messages.username') }}" value="{{ get_system_setting('paypal_username') }}">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group required">
                        <label for="paypal_password">{{ __('messages.password') }}</label>
                        <input name="paypal_password" type="text" class="form-control" placeholder="{{ __('messages.password') }}" value="{{ get_system_setting('paypal_password') }}">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group required">
                        <label for="paypal_signature">{{ __('messages.signature') }}</label>
                        <input name="paypal_signature" type="text" class="form-control" placeholder="{{ __('messages.enter_signature') }}" value="{{ get_system_setting('paypal_signature') }}">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="paypal_test_mode">{{ __('messages.test_mode') }}</label>
                        <select name="paypal_test_mode" class="form-control">
                            <option value="0" {{ get_system_setting('paypal_test_mode') == false ? 'selected' : '' }}>{{ __('messages.false') }}</option>
                            <option value="1" {{ get_system_setting('paypal_test_mode') == true  ? 'selected' : '' }}>{{ __('messages.true') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="paypal_active">{{ __('messages.active') }}</label>
                        <select name="paypal_active" class="form-control">
                            <option value="0" {{ get_system_setting('paypal_active') == false ? 'selected' : '' }}>{{ __('messages.disabled') }}</option>
                            <option value="1" {{ get_system_setting('paypal_active') == true  ? 'selected' : '' }}>{{ __('messages.active') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group text-center mt-5">
                <button class="btn btn-primary save_form_button">{{ __('messages.save_settings') }}</button>
            </div>
        </div>
    </div>
</div>

