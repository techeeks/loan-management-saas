@extends('layouts.onboard')

@section('title', __('messages.checkout'))

@section('content')
    <div class="page__heading">
        <h1>{{ __('messages.checkout') }}</h1>
    </div> 

    <div class="row card-group-row pt-2">
        <div id="payment_options" class="col-12">
            @if(\App\Models\SystemSetting::isPaypalActive())
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
                            <form class="d-inline-block" method="POST" action="{{ route('order.payment.paypal', ['plan' => $plan->slug, 'orderId' => $orderId]) }}">
                                @csrf
                                <button class="btn paypal-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 32" preserveAspectRatio="xMinYMin meet">
                                        <path fill="#009cde" d="M 20.905 9.5 C 21.185 7.4 20.905 6 19.782 4.7 C 18.564 3.3 16.411 2.6 13.697 2.6 L 5.739 2.6 C 5.271 2.6 4.71 3.1 4.615 3.6 L 1.339 25.8 C 1.339 26.2 1.62 26.7 2.088 26.7 L 6.956 26.7 L 6.675 28.9 C 6.581 29.3 6.862 29.6 7.236 29.6 L 11.356 29.6 C 11.825 29.6 12.292 29.3 12.386 28.8 L 12.386 28.5 L 13.228 23.3 L 13.228 23.1 C 13.322 22.6 13.79 22.2 14.258 22.2 L 14.821 22.2 C 18.845 22.2 21.935 20.5 22.871 15.5 C 23.339 13.4 23.153 11.7 22.029 10.5 C 21.748 10.1 21.279 9.8 20.905 9.5 L 20.905 9.5"/>
                                        <path fill="#012169" d="M 20.905 9.5 C 21.185 7.4 20.905 6 19.782 4.7 C 18.564 3.3 16.411 2.6 13.697 2.6 L 5.739 2.6 C 5.271 2.6 4.71 3.1 4.615 3.6 L 1.339 25.8 C 1.339 26.2 1.62 26.7 2.088 26.7 L 6.956 26.7 L 8.267 18.4 L 8.173 18.7 C 8.267 18.1 8.735 17.7 9.296 17.7 L 11.636 17.7 C 16.224 17.7 19.782 15.7 20.905 10.1 C 20.812 9.8 20.905 9.7 20.905 9.5"/>
                                        <path fill="#003087" d="M 9.485 9.5 C 9.577 9.2 9.765 8.9 10.046 8.7 C 10.232 8.7 10.326 8.6 10.513 8.6 L 16.692 8.6 C 17.442 8.6 18.189 8.7 18.753 8.8 C 18.939 8.8 19.127 8.8 19.314 8.9 C 19.501 9 19.688 9 19.782 9.1 C 19.875 9.1 19.968 9.1 20.063 9.1 C 20.343 9.2 20.624 9.4 20.905 9.5 C 21.185 7.4 20.905 6 19.782 4.6 C 18.658 3.2 16.506 2.6 13.79 2.6 L 5.739 2.6 C 5.271 2.6 4.71 3 4.615 3.6 L 1.339 25.8 C 1.339 26.2 1.62 26.7 2.088 26.7 L 6.956 26.7 L 8.267 18.4 L 9.485 9.5 Z"/>
                                    </svg> 
                                    {{ __('messages.pay_with_paypal') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if(\App\Models\SystemSetting::isStripeActive())
                <div class="card">
                    <div class="card-header" id="stripe">
                        <h5 class="mb-0">
                            <button class="btn btn-link">
                                {{ __('messages.pay_with_stripe') }} 
                            </button>
                        </h5>
                    </div>

                    <div id="stripe" class="collapse show">
                        <div class="card-body">
                            <form action="{{ route('order.payment.stripe', ['plan' => $plan->slug, 'orderId' => $orderId]) }}" method="POST" id="payment-form">
                                @csrf
                                <input type="hidden" name="paymentMethodId" id="paymentMethodId">
                                <div>
                                    <label>{{ __('messages.card_holder') }}</label>
                                    <input id="cardholder-name" class="form-control mb-4" placeholder="{{ __('messages.card_holder') }}" type="text">
                                    <!-- placeholder for Elements -->
                                    <div id="card-element" class="form-control"></div>
                                    <!-- Used to display form errors -->
                                    <div id="card-errors" role="alert"></div>
                                </div>
            
                                <div class="d-flex flex-row mt-4 justify-content-end align-items-center">
                                    <button id="card-button" class="btn btn-primary">
                                        {{ __('messages.pay') }} ({{ money($plan->price, $plan->currency) }})
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if(\App\Models\SystemSetting::isRazorpayActive())
                <div class="card">
                    <div class="card-header" id="razorpay">
                        <h5 class="mb-0">
                            <button class="btn btn-link">
                                {{ __('messages.pay_with_razorpay') }} 
                            </button>
                        </h5>
                    </div>

                    <div id="razorpay" class="collapse show">
                        <div class="card-body">
                            <form action="{{ $razorpay_callbackUrl }}" method="POST">
                                <script
                                    src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-key="{{ get_system_setting('razorpay_id') }}" 
                                    data-amount="{{$plan->price}}" 
                                    data-currency="{{$plan->currency}}" 
                                    data-order_id="{{ $razorpay_order['id'] }}"
                                    data-buttontext="{{ __('messages.pay_with_razorpay') }}"
                                    data-name="{{ $plan->name }}"
                                    data-description="{{$plan->description}}" 
                                    data-image="{{ asset(get_system_setting('application_logo')) }}"
                                ></script>
                                <input type="hidden" name="hidden">
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@if(\App\Models\SystemSetting::isStripeActive())
    @section('page_body_scripts')
        <script src='https://js.stripe.com/v3/' type='text/javascript'></script>
        <script>

            var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '1.8rem'
                }
            };

            var stripe = Stripe("{{ get_system_setting('stripe_public_key') }}");

            var elements = stripe.elements();
            var cardElement = elements.create('card', {style: style});
            cardElement.mount('#card-element');

            var cardholderName = document.getElementById('cardholder-name');
            var cardButton = document.getElementById('card-button');
            var paymentMethodIdField = document.getElementById('paymentMethodId');
            var myForm = document.getElementById('payment-form');

            cardButton.addEventListener('click', function(ev) {
                ev.preventDefault();
                cardButton.disabled = true;

                stripe.createPaymentMethod('card', cardElement, {
                    billing_details: {name: cardholderName.value }
                }).then(function(result) {
                    if (result.error) {
                        cardButton.disabled = false;
                        alert(result.error.message);
                    } else {
                        paymentMethodIdField.value = result.paymentMethod.id;
                        myForm.submit();
                    }
                });
            });
        </script>
    @endsection
@endif