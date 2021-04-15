@extends('layouts.app', ['page' => 'settings'])

@section('title', __('messages.membership'))
    
@section('content')
    <div class="page__heading">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">business</i></a></li>
                <li class="breadcrumb-item">{{ __('messages.settings') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.membership') }}</li>
            </ol>
        </nav>
        <h1 class="m-0">{{ __('messages.membership') }}</h1>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('application.settings._aside', ['tab' => 'membership'])
        </div>
        <div class="col-lg-9">
            
            <div class="card card-form">
                <div class="row no-gutters">
                    <div class="col-12 col-md-6 card-form__body card-body bg-white">
                        <div class="form-group mb-4">
                            <p class="h5 mb-0">
                                <strong class="headings-color">{{ __('messages.current_membership') }}</strong>
                            </p>
                        </div>
                        <div class="font-weight-bold">{{ __('messages.plan') }}: <p class="font-weight-normal">{{ $subscription->plan->name }}</p></div>
                        <div class="font-weight-bold">{{ __('messages.status') }}: <p class="font-weight-normal">{!! $subscription->html_status !!}</p></div>
                        @if($subscription->onTrial())
                            <div class="font-weight-bold">{{ __('messages.trial_ends') }}: <p class="font-weight-normal">{{ $subscription->trial_ends_at->format($dateFormat) }}</p></div>
                        @else
                            <div class="font-weight-bold">{{ __('messages.expiry_date') }}: <p class="font-weight-normal">{{ $subscription->ends_at->format($dateFormat) }}</p></div>
                        @endif

                        <div class="form-group text-left mt-4">
                            <a href="{{ route('order.plans') }}" class="btn btn-primary">{{ __('messages.see_plans') }}</a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 card-form__body card-body bg-white">
                        <div class="form-group mb-4">
                            <p class="h5 mb-0">
                                <strong class="headings-color">{{ __('messages.feature_usage') }}</strong>
                            </p>
                        </div>
                        <div class="font-weight-bold">{{ __('messages.customers') }}: <p class="font-weight-normal">{{ $subscription->getFeatureUsage('customers') ?? 0 }} / {{ $subscription->getFeatureValue('customers') ?? 0 }}</p></div>
                        <div class="font-weight-bold">{{ __('messages.products') }}: <p class="font-weight-normal">{{ $subscription->getFeatureUsage('products') ?? 0 }} / {{ $subscription->getFeatureValue('products') ?? 0 }}</p></div>
                        <div class="font-weight-bold">{{ __('messages.estimates_per_month') }}: <p class="font-weight-normal">{{ $subscription->getFeatureUsage('estimates_per_month') ?? 0 }} / {{ $subscription->getFeatureValue('estimates_per_month') ?? 0 }}</p></div>
                        <div class="font-weight-bold">{{ __('messages.invoices_per_month') }}: <p class="font-weight-normal">{{ $subscription->getFeatureUsage('invoices_per_month') ?? 0}} / {{ $subscription->getFeatureValue('invoices_per_month') ?? 0 }}</p></div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

