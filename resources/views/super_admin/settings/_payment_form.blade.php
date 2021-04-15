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

<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.stripe_settings') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group required">
                        <label for="stripe_public_key">{{ __('messages.publishable_key') }}</label>
                        <input name="stripe_public_key" type="text" class="form-control" placeholder="{{ __('messages.publishable_key') }}" value="{{ get_system_setting('stripe_public_key') }}">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group required">
                        <label for="stripe_secret_key">{{ __('messages.secret_key') }}</label>
                        <input name="stripe_secret_key" type="text" class="form-control" placeholder="{{ __('messages.secret_key') }}" value="{{ get_system_setting('stripe_secret_key') }}">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="stripe_test_mode">{{ __('messages.test_mode') }}</label>
                        <select name="stripe_test_mode" class="form-control">
                            <option value="0" {{ get_system_setting('stripe_test_mode') == false ? 'selected' : '' }}>{{ __('messages.false') }}</option>
                            <option value="1" {{ get_system_setting('stripe_test_mode') == true  ? 'selected' : '' }}>{{ __('messages.true') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="stripe_active">{{ __('messages.active') }}</label>
                        <select name="stripe_active" class="form-control">
                            <option value="0" {{ get_system_setting('stripe_active') == false ? 'selected' : '' }}>{{ __('messages.disabled') }}</option>
                            <option value="1" {{ get_system_setting('stripe_active') == true  ? 'selected' : '' }}>{{ __('messages.active') }}</option>
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

<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.razorpay_settings') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group required">
                        <label for="razorpay_id">{{ __('messages.razorpay_id') }}</label>
                        <input name="razorpay_id" type="text" class="form-control" placeholder="{{ __('messages.razorpay_id') }}" value="{{ get_system_setting('razorpay_id') }}">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group required">
                        <label for="razorpay_secret_key">{{ __('messages.razorpay_secret_key') }}</label>
                        <input name="razorpay_secret_key" type="text" class="form-control" placeholder="{{ __('messages.razorpay_secret_key') }}" value="{{ get_system_setting('razorpay_secret_key') }}">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="razorpay_test_mode">{{ __('messages.test_mode') }}</label>
                        <select name="razorpay_test_mode" class="form-control">
                            <option value="0" {{ get_system_setting('razorpay_test_mode') == false ? 'selected' : '' }}>{{ __('messages.false') }}</option>
                            <option value="1" {{ get_system_setting('razorpay_test_mode') == true  ? 'selected' : '' }}>{{ __('messages.true') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="razorpay_active">{{ __('messages.active') }}</label>
                        <select name="razorpay_active" class="form-control">
                            <option value="0" {{ get_system_setting('razorpay_active') == false ? 'selected' : '' }}>{{ __('messages.disabled') }}</option>
                            <option value="1" {{ get_system_setting('razorpay_active') == true  ? 'selected' : '' }}>{{ __('messages.active') }}</option>
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
