@extends('layouts.onboard')

@section('title', __('messages.checkout'))

@section('content')
<div class="page__heading">
    <h1>{{ __('messages.checkout') }}</h1>
</div>
<div class="row card-group-row pt-2">
    <div id="payment_options" class="col-12">
        <div class="card">
            <div class="card-header" id="voucher">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        {{ __('messages.pay_with_voucher') }}
                    </button>
                </h5>
            </div>

            <div class="collapse show">
                <div class="card-body">
                    <form class="d-inline-block" method="POST"
                        action="{{ route('order.payment.voucher', ['plan' => $plan->slug, 'orderId' => $orderId]) }}">
                        @csrf

                        <div class="form-group required">
                            <label for="voucher_code">Voucher Code</label>
                            <input type="text" name="voucher_code" id="voucher_code" class="form-control" required />
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection