@extends('layouts.app', ['page' => 'super_admin.dashboard'])

@section('title', __('messages.dashboard'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.dashboard') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.dashboard') }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="row card-group-row">
        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">{{ __('messages.users') }}</div>
                    <div class="text-amount">{{ isset($users) ? $users : '0'}}</div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">perm_identity</i></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">{{ __('messages.active_subscriptions') }}</div>
                    <div class="text-amount">{{ isset($active_subscriptions) ? $active_subscriptions : '0'}}</div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">assessment</i></div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 card-group-row__col">
            <div class="card card-group-row__card card-body card-body-x-lg flex-row align-items-center">
                <div class="flex">
                    <div class="card-header__title text-muted mb-2">{{ __('messages.total_earnings') }}</div>
                    <div class="text-amount">{{ money($total_earnings, get_system_setting('application_currency')) }}</div>
                </div>
                <div><i class="material-icons icon-muted icon-40pt ml-3">monetization_on</i></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex align-items-center">
            <h3 class="card-header__title mb-0 fs-1-3rem">{{ __('messages.earnings_this_year') }}</h3>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="earningsChart" class="chart-canvas chartjs-render-monitor" width="1998" height="600"></canvas>
            </div>
        </div>
    </div>

@endsection

@section('page_body_scripts')
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/vendor/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/chartjs-rounded-bar.js') }}"></script>
    <script src="{{ asset('assets/js/charts.js') }}"></script>

    <script>
        (function () {
            'use strict';
            Charts.init();

            var Orders = function Orders(id) {
                var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'roundedBar';
                var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
                options = Chart.helpers.merge({
                    barRoundness: 1.2,
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function callback(a) {
                                    return a.toLocaleString("en-US", {style:"currency", currency: "{{ get_system_setting('application_currency') }}"});
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function label(a, e) {
                                var t = e.datasets[a.datasetIndex].label || "",
                                    o = a.yLabel,
                                    r = "",
                                    val = o.toLocaleString("en-US", {style:"currency", currency: "{{ get_system_setting('application_currency') }}"});
                                return 1 < e.datasets.length && (r += '<span class="popover-body-label mr-auto">' + t + "</span>"), r += '<span class="popover-body-value">' + val + "</span>";
                            }
                        }
                    }
                }, options);
                var data = {
                    labels: @json($earnings_stats_label),
                    datasets: [{
                        label: "Earnings",
                        data: @json($earnings_stats)
                    }]
                };
                Charts.create(id, type, options, data);
            };
            Orders('#earningsChart');
        })();
    </script>
@endsection
