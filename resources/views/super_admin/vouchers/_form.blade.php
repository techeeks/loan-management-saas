<div class="card card-form">
    <div class="row no-gutters">
        <div class="col-lg-4 card-body">
            <p><strong class="headings-color">{{ __('messages.subscription_vouchers') }}</strong></p>
        </div>
        <div class="col-lg-8 card-form__body card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group required">
                        <label for="name">{{ __('messages.plan') }}</label>
                        <select required name="plan_id" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="plan_id" required>
                            <option disabled selected>Select Plan</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ $plan->id == $voucher->plan_id ? 'selected=""' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group required">
                        <label for="voucher_name">{{ __('messages.voucher_name') }}</label>
                        <input name="voucher_name" type="text" class="form-control" placeholder="{{ __('messages.voucher_name') }}"  value="{{ $voucher->voucher_name  }}" required>
                    </div>
                </div>
               
            </div> 
            <div class="form-group text-center mt-5">
                <a href="{{ route('super_admin.vouchers')}}" class="btn btn-danger text-white">{{ __('messages.cancel') }}</a>
                <button type="submit" class="btn btn-primary ">{{ __('messages.save') }}</button>
            </div>
        </div>
    </div>
</div>