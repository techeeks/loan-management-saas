<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.mail_settings') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_driver">{{ __('messages.mail_driver') }}</label>
                        <input name="mail_driver" type="text" class="form-control" placeholder="{{ __('messages.mail_driver') }}" value="{{ env('MAIL_DRIVER') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_host">{{ __('messages.mail_host') }}</label>
                        <input name="mail_host" type="text" class="form-control" placeholder="{{ __('messages.mail_host') }}" value="{{ env('MAIL_HOST') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_port">{{ __('messages.mail_port') }}</label>
                        <input name="mail_port" type="text" class="form-control" placeholder="{{ __('messages.mail_port') }}" value="{{ env('MAIL_PORT') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_encryption">{{ __('messages.mail_encryption') }}</label>
                        <input name="mail_encryption" type="text" class="form-control" placeholder="{{ __('messages.mail_encryption') }}" value="{{ env('MAIL_ENCRYPTION') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_username">{{ __('messages.mail_username') }}</label>
                        <input name="mail_username" type="text" class="form-control" placeholder="{{ __('messages.mail_username') }}" value="{{ env('MAIL_USERNAME') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_password">{{ __('messages.mail_password') }}</label>
                        <input name="mail_password" type="text" class="form-control" placeholder="{{ __('messages.mail_password') }}" value="{{ env('MAIL_PASSWORD') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_from_address">{{ __('messages.mail_from_address') }}</label>
                        <input name="mail_from_address" type="text" class="form-control" placeholder="{{ __('messages.mail_from_address') }}" value="{{ env('MAIL_FROM_ADDRESS') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="mail_from_name">{{ __('messages.mail_from_name') }}</label>
                        <input name="mail_from_name" type="text" class="form-control" placeholder="{{ __('messages.mail_from_name') }}" value="{{ env('MAIL_FROM_NAME') }}">
                    </div>
                </div>
            </div>

            <div class="form-group text-center mt-5">
                <button class="btn btn-primary save_form_button">{{ __('messages.save_settings') }}</button>
            </div>
        </div>
    </div>
</div>