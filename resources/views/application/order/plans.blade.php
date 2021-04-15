@extends('layouts.onboard')

@section('title', __('messages.plans'))

@section('content')
    <div class="page__heading">
        <h1>{{ __('messages.plans') }}</h1>
        <p class="m-0"><strong class="headings-color">{{ __('messages.plans_description') }}</strong></p>
    </div> 

    <div class="row card-group-row pt-2">
        @foreach(\App\Models\Plan::orderBy('order', 'asc')->get() as $plan)
            <div class="col-md-6 col-lg-4 card-group-row__col">
                <div class="card card-group-row__card pricing__card">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center">
                            <h4 class="pricing__title mb-0">{{ $plan->name }}</h4>
                            <div class="d-flex align-items-center justify-content-center border-bottom-2 flex pb-3">
                                @if($plan->isFree())
                                    <span class="pricing__amount headings-color">{{ __('messages.free') }}</span>
                                @else
                                    <span class="pricing__amount headings-color">{{ money($plan->price, $plan->currency) }}</span>
                                    <span class="d-flex flex-column">
                                        <span class="pricing__duration text-dark-gray">/ {{ __('messages.'.$plan->invoice_interval) }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <ul class="list-unstyled pricing__features">
                                <li>{{ __('bikin.x_customers', ['count' => $plan->getFeatureBySlug('customers')->value]) }}</li>
                                @if(isset($plan->getFeatureBySlug('members_per_month')->value))
                                <li>{{ __('bikin.x_members', ['count' => $plan->getFeatureBySlug('members_per_month')->value]) }}</li>
                                @endif
                            </ul>
                            @if($plan->hasTrial() & !$currentCompany->subscriptions->isNotEmpty())
                                <a href="{{ route('order.checkout', ['company_uid' => $currentCompany->uid, 'plan' => $plan->slug]) }}" class="btn btn-primary mt-auto">{{ __('messages.start_trial') }}</a>
                            @else
                                <a href="{{ route('order.checkout', ['company_uid' => $currentCompany->uid, 'plan' => $plan->slug]) }}" class="btn btn-success mt-auto">{{ __('messages.purchase') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
