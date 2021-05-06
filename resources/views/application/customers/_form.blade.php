<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.customer_information') }}</strong></p>
            <p class="text-muted">{{ __('messages.basic_customer_information') }}</p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="display_name">{{ __('messages.display_name') }}</label>
                        <input name="display_name" type="text" class="form-control" placeholder="{{ __('messages.display_name') }}" value="{{ $customer->display_name }}" required>
                    </div>
                </div>
               
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="email">{{ __('messages.email') }}</label>
                        <input name="email" type="email" class="form-control" placeholder="{{ __('messages.email') }}" value="{{ $customer->email }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="phone">{{ __('messages.phone') }}</label>
                        <input name="phone" type="text" class="form-control" placeholder="{{ __('messages.phone') }}" value="{{ $customer->phone }}">
                    </div>
                </div>
            </div>

          
           
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.billing_address') }}</strong></p>
            <p class="text-muted">{{ __('messages.customer_billing_address') }}</p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <p class="row"><strong class=" col headings-color">{{ __('messages.billing_address') }}</strong></p>

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="billing[country_id]">{{ __('messages.country') }}</label>
                        <select id="billing[country_id]" name="billing[country_id]" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="billing[country_id]" required>
                            <option disabled selected>{{ __('messages.select_country') }}</option>
                            @foreach(get_countries_select2_array() as $option)
                                <option value="{{ $option['id'] }}" {{ $customer->billing->country_id == $option['id'] ? 'selected=""' : '' }}>{{ $option['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="billing[state]">{{ __('messages.state') }}</label>
                        <input name="billing[state]" type="text" class="form-control" value="{{ $customer->billing->state }}" placeholder="{{ __('messages.state') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="billing[city]">{{ __('messages.city') }}</label>
                        <input name="billing[city]" type="text" class="form-control" value="{{ $customer->billing->city }}" placeholder="{{ __('messages.city') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="billing[zip]">{{ __('messages.postal_code') }}</label>
                        <input name="billing[zip]" type="text" class="form-control" value="{{ $customer->billing->zip }}" placeholder="{{ __('messages.postal_code') }}">
                    </div>
                </div>
            </div>

            <div class="form-group required">
                <label for="billing[address_1]">{{ __('messages.address') }}</label>
                <textarea name="billing[address_1]" class="form-control" rows="2" placeholder="{{ __('messages.address') }}" required>{{ $customer->billing->address_1 }}</textarea>
            </div>
        </div>
    </div> 
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.guarantor') }}</strong></p>
            <p class="text-muted">{{ __('messages.guarantor_details') }}</p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
           
            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="guarantor_name">{{ __('messages.guarantor_name') }}</label>
                        <input name="guarantor_name" type="text" class="form-control" placeholder="{{ __('messages.guarantor_name') }}" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="guarantor_phone">{{ __('messages.phone') }}</label>
                        <input name="guarantor_phone" type="text" class="form-control" placeholder="{{ __('messages.phone') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="gurantor[country_id]">{{ __('messages.country') }}</label>
                        <select id="gurantor[country_id]" name="gurantor[country_id]" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="billing[country_id]" required>
                            <option disabled selected>{{ __('messages.select_country') }}</option>
                            @foreach(get_countries_select2_array() as $option)
                                <option value="{{ $option['id'] }}" >{{ $option['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="gurantor[state]">{{ __('messages.state') }}</label>
                        <input name="gurantor[state]" type="text" class="form-control"  placeholder="{{ __('messages.state') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="gurantor[city]">{{ __('messages.city') }}</label>
                        <input name="gurantor[city]" type="text" class="form-control" placeholder="{{ __('messages.city') }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="gurantor[zip]">{{ __('messages.postal_code') }}</label>
                        <input name="gurantor[zip]" type="text" class="form-control" placeholder="{{ __('messages.postal_code') }}">
                    </div>
                </div>
            </div>

            <div class="form-group required">
                <label for="gurantor[address_1]">{{ __('messages.address') }}</label>
                <textarea name="gurantor[address_1]" class="form-control" rows="2" placeholder="{{ __('messages.address') }}" required></textarea>
            </div>
        </div>
    </div> 


    @if($customer->getCustomFields()->count() > 0)
        <div class="row no-gutters">
            <div class="col-lg-4 card-body">
                <p><strong class="headings-color">{{ __('messages.custom_fields') }}</strong></p>
            </div>
            <div class="col-lg-8 card-form__body card-body">
                <div class="row">
                    @foreach ($customer->getCustomFields() as $custom_field)
                        @include('layouts._custom_field', ['model' => $customer, 'custom_field' => $custom_field])
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<div class="form-group text-center mt-5">
    <button type="submit" class="btn btn-primary">{{ __('messages.save_customer') }}</button>
</div>
