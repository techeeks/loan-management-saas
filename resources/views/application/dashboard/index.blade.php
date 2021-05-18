@extends('layouts.app', ['page' => 'dashboard'])

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
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body-x-lg card-body d-flex flex-row align-items-center">
                    <div class="flex">
                        <a href="{{route('customers', ['company_uid' => $currentCompany->uid])}}" class="text-decoration-none">
                            <div class="card-header__title text-muted mb-2 d-flex">
                                {{ __('messages.customers') }}
                            </div>
                            <span class="h4 m-0">{{ $customersCount }}</span>
                        </a>
                    </div>
                    <div><i class="material-icons icon-muted icon-40pt ml-3">account_box</i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body-x-lg card-body d-flex flex-row align-items-center">
                    <div class="flex">
                        <div class="card-header__title text-muted mb-2 d-flex">{{ __('messages.total_loaned') }}</div>
                        <span class="h4 m-0">{{ currencyFormat($total_loan, $currentCompany->currency->symbol) }}</span>
                    </div>
                    <div><i class="material-icons icon-muted icon-40pt ml-3">monetization_on</i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body-x-lg card-body d-flex flex-row align-items-center">
                    <div class="flex">
                        <div class="card-header__title text-muted mb-2 d-flex">{{ __('messages.total_repayment') }}</div>
                        <span class="h4 m-0">{{ currencyFormat($total_payments, $currentCompany->currency->symbol) }}</span>
                    </div>
                    <div><i class="material-icons icon-muted icon-40pt ml-3">monetization_on</i></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 card-group-row__col">
            <div class="card card-group-row__card">
                <div class="card-body-x-lg card-body d-flex flex-row align-items-center">
                    <div class="flex">
                        <div class="card-header__title text-muted mb-2 d-flex">{{ __('messages.due_loans') }}</div>
                        <span class="h4 m-0">{{ $total_due }}</span>
                    </div>
                    <div><i class="material-icons icon-muted icon-40pt ml-3">monetization_on</i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex align-items-center">
            <h3 class="card-header__title mb-0 fs-1-3rem">{{ __('messages.loaned_amount_per_month') }}</h3>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="loanChart" class="chart-canvas chartjs-render-monitor" width="1900" height="600"></canvas>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-white d-flex align-items-center">
            <h3 class="card-header__title mb-0 fs-1-3rem">{{ __('messages.repayment_amount_per_month') }}</h3>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="PaymentChart" class="chart-canvas chartjs-render-monitor" width="1900" height="600"></canvas>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex align-items-center">
                <h3 class="card-header__title mb-0 fs-1-3rem">{{ __('messages.overdue_loans') }}</h3>
            </div>
            @if($due_loans->count() > 0)
            <div class="table-responsive">
                <table class="table table-xl mb-0 thead-border-top-0 table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('messages.reference_number') }}</th>
                            <th>{{ __('messages.customer') }}</th>
                            <th>{{ __('messages.amount') }}</th>
                            <th>{{ __('messages.amount_paid') }}</th>
                            <th>{{ __('messages.balance') }}</th>
                            <th>{{ __('messages.loan_date') }}</th>
                            <th>{{ __('messages.return_date') }}</th>
                            <th>{{ __('messages.status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="loans">
                        @foreach ($due_loans as $loan)
                        <tr>
                            <td>
                                {{ $loan->reference_number }}
                            </td>
                            <td>
                                {{ $loan->customer->display_name}}
                            </td>

                            <td>
                                {{ currencyFormat($loan->amount, $loan->currency->symbol) }}
                            </td>
                            <td>
                                {{ currencyFormat($loan->totalPaid($loan->id), $loan->currency->symbol)}}
                            </td>
                            <td>
                                {{ currencyFormat($loan->amount-$loan->totalPaid($loan->id), $loan->currency->symbol)}}
                            </td>
                            <td>
                                {{ $loan->loan_date}}
                            </td>
                            <td>
                                {{ $loan->return_date}}
                            </td>
                            <td>
                                <div class="badge badge-danger fs-0-9rem">
                                    {{ $loan->status }}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row card-footer  justify-content-center text-center">
                    <a href="{{ route('reports.overdue.loans', ['company_uid' => $currentCompany->uid])  }}">View All</a>
                </div>
            </div>
            @else
            <div class="row justify-content-center card-body pb-0 pt-5">
                <i class="material-icons fs-64px">description</i>
            </div>
            <div class="row justify-content-center card-body pb-5">
                <p class="h4">No Record Found</p>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex align-items-center">
                <h3 class="card-header__title mb-0 fs-1-3rem">{{ __('messages.latest_repayment') }}</h3>
            </div>
            @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="table mb-0 thead-border-top-0 table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('messages.payment_#') }}</th>
                            <th>{{ __('messages.reference_number') }}</th>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.payment_type') }}</th>
                            <th>{{ __('messages.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody class="list" id="payments">
                        @foreach ($payments as $payment)
                            <tr>
                                <td>
                                    {{ $payment_prefix.'-'.$payment->payment_number }}
                                </td>
                                <td>
                                    {{ $payment->loan->reference_number }}
                                </td>
                                <td>
                                    {{ $payment->payment_date }}
                                </td>
                                <td>
                                    {{ $payment->payment_method->name ?? "-"}}
                                </td>
                                <td>
                                    {{ currencyFormat($payment->amount, $payment->loan->currency->symbol) }}
                                </td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row card-footer  justify-content-center text-center">
                    <a href="{{ route('loan.payments', ['company_uid' => $currentCompany->uid]) }}">View All</a>
                </div>
            </div>
           
        @else
            <div class="row justify-content-center card-body pb-0 pt-5">
                <i class="material-icons fs-64px">payment</i>
            </div>
            <div class="row justify-content-center card-body pb-5">
                <p class="h4">{{ __('messages.no_payments_yet') }}</p>
            </div>
        @endif
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
                                    return a.toLocaleString("en-US", {style:"currency", currency: "{{ $currency_code }}"});
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
                                    val = o.toLocaleString("en-US", {style:"currency", currency: "{{ $currency_code }}"});
                                return 1 < e.datasets.length && (r += '<span class="popover-body-label mr-auto">' + t + "</span>"), r += '<span class="popover-body-value">' + val + "</span>";
                            }
                        }
                    }
                }, options);
                var data = {
                    labels: @json($expense_stats_label),
                    datasets: [{
                        label: "Loans",
                        data: @json($loan_per_month)
                    }]
                };
                Charts.create(id, type, options, data);
            };
            Orders('#loanChart');
            var payments = function payments(id) {
                var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'roundedBar';
                var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
                options = Chart.helpers.merge({
                    barRoundness: 1.2,
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function callback(a) {
                                    return a.toLocaleString("en-US", {style:"currency", currency: "{{ $currency_code }}"});
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
                                    val = o.toLocaleString("en-US", {style:"currency", currency: "{{ $currency_code }}"});
                                return 1 < e.datasets.length && (r += '<span class="popover-body-label mr-auto">' + t + "</span>"), r += '<span class="popover-body-value">' + val + "</span>";
                            }
                        }
                    }
                }, options);
                var data = {
                    labels: @json($expense_stats_label),
                    datasets: [{
                        label: "Loans",
                        data: @json($payments_per_moth)
                    }]
                };
                Charts.create(id, type, options, data);
            };
            payments('#PaymentChart');
        })();
    </script>
@endsection
