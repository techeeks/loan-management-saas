@extends('layouts.onboard')

@section('title', __('messages.checkout'))

@section('content')
<div class="page__heading">
    <h1>{{ __('messages.checkout') }}</h1>
</div>
<div class="row card-group-row pt-2">
    <div id="payment_options" class="col-12">
        <div class="card">
            <div class="card-header" id="paypal">
                <h5 class="mb-0">
                    <button class="btn btn-link">
                        {{ __('messages.pay_with_paypal') }}
                    </button>
                </h5>
            </div>

            <div id="paypal" class="collapse show">
                <div class="card-body">
                    <form class="d-inline-block" method="POST"
                        action="{{ route('order.payment.paypal', ['plan' => $plan->slug, 'orderId' => $orderId]) }}">
                        @csrf
                        <button class="btn paypal-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 32"
                                preserveAspectRatio="xMinYMin meet">
                                <path fill="#009cde"
                                    d="M 20.905 9.5 C 21.185 7.4 20.905 6 19.782 4.7 C 18.564 3.3 16.411 2.6 13.697 2.6 L 5.739 2.6 C 5.271 2.6 4.71 3.1 4.615 3.6 L 1.339 25.8 C 1.339 26.2 1.62 26.7 2.088 26.7 L 6.956 26.7 L 6.675 28.9 C 6.581 29.3 6.862 29.6 7.236 29.6 L 11.356 29.6 C 11.825 29.6 12.292 29.3 12.386 28.8 L 12.386 28.5 L 13.228 23.3 L 13.228 23.1 C 13.322 22.6 13.79 22.2 14.258 22.2 L 14.821 22.2 C 18.845 22.2 21.935 20.5 22.871 15.5 C 23.339 13.4 23.153 11.7 22.029 10.5 C 21.748 10.1 21.279 9.8 20.905 9.5 L 20.905 9.5" />
                                <path fill="#012169"
                                    d="M 20.905 9.5 C 21.185 7.4 20.905 6 19.782 4.7 C 18.564 3.3 16.411 2.6 13.697 2.6 L 5.739 2.6 C 5.271 2.6 4.71 3.1 4.615 3.6 L 1.339 25.8 C 1.339 26.2 1.62 26.7 2.088 26.7 L 6.956 26.7 L 8.267 18.4 L 8.173 18.7 C 8.267 18.1 8.735 17.7 9.296 17.7 L 11.636 17.7 C 16.224 17.7 19.782 15.7 20.905 10.1 C 20.812 9.8 20.905 9.7 20.905 9.5" />
                                <path fill="#003087"
                                    d="M 9.485 9.5 C 9.577 9.2 9.765 8.9 10.046 8.7 C 10.232 8.7 10.326 8.6 10.513 8.6 L 16.692 8.6 C 17.442 8.6 18.189 8.7 18.753 8.8 C 18.939 8.8 19.127 8.8 19.314 8.9 C 19.501 9 19.688 9 19.782 9.1 C 19.875 9.1 19.968 9.1 20.063 9.1 C 20.343 9.2 20.624 9.4 20.905 9.5 C 21.185 7.4 20.905 6 19.782 4.6 C 18.658 3.2 16.506 2.6 13.79 2.6 L 5.739 2.6 C 5.271 2.6 4.71 3 4.615 3.6 L 1.339 25.8 C 1.339 26.2 1.62 26.7 2.088 26.7 L 6.956 26.7 L 8.267 18.4 L 9.485 9.5 Z" />
                            </svg>
                            {{ __('messages.pay_with_paypal') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="paypal">
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