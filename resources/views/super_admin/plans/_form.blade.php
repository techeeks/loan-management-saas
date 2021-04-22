<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.plan_information') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="name">{{ __('messages.name') }}</label>
                        <input name="name" type="text" class="form-control" placeholder="{{ __('messages.name') }}" value="{{ $plan->name }}" required>
                    </div>
                </div> 
                <div class="col">
                    <div class="form-group">
                        <label for="description">{{ __('messages.description') }}</label>
                        <input name="description" type="text" class="form-control" placeholder="{{ __('messages.description') }}" value="{{ $plan->description }}">
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="price">{{ __('messages.price') }}</label>
                        <input name="price" type="text" class="form-control price_input" placeholder="{{ __('messages.price') }}" autocomplete="off" value="{{ $plan->price ?? 0 }}" required>
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="invoice_interval">{{ __('messages.invoice_interval') }}</label>
                        <select name="invoice_interval"  class="form-control" required>
                            <option value="month" {{ $plan->invoice_interval === 'month' ? 'selected=""' : ''}}>{{ __('messages.month') }}</option>
                            <option value="year" {{ $plan->invoice_interval === 'year' ? 'selected=""' : ''}}>{{ __('messages.year') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group required">
                        <label for="trial_period">{{ __('messages.trial_period') }}</label>
                        <input name="trial_period" type="number" class="form-control" placeholder="{{ __('messages.trial_period') }}" value="{{ $plan->trial_period }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.plan_feature_information') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="features[customers]">{{ __('messages.feature_customers') }}</label>
                        <input name="features[customers]" type="text" class="form-control" placeholder="{{ __('messages.feature_customers') }}" value="{{ isset($plan->getFeatureBySlug('customers')->value) ? $plan->getFeatureBySlug('customers')->value : '' }}" required>
                    </div>
                </div> 
                <div class="col">
                    <div class="form-group required">
                        <label for="features[members_per_month]">{{ __('messages.member_per_month') }}</label>
                        <input name="features[members_per_month]" type="text" class="form-control" placeholder="{{ __('messages.member_per_month') }}" value="{{ isset($plan->getFeatureBySlug('members_per_month')->value) ? $plan->getFeatureBySlug('members_per_month')->value : '' }}" required>
                    </div>
                </div> 
            </div> 
            <div class="form-group text-center mt-5">
                <button class="btn btn-primary save_form_button">{{ __('messages.save_plan') }}</button>
            </div>
        </div>
    </div>
</div>