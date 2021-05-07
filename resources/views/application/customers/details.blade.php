@extends('layouts.app', ['page' => 'customers'])

@section('title', __('messages.customer_details'))

@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a
                            href="{{ route('customers', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.customers') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.customer_details') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.customer_details') }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="row pl-4 pr-4">
                    <div class="col-3 col-md-3 mt-4 mb-4">
                        <h5>{{ __('messages.customer_details') }}</h5>
                        <p class="mb-1">
                            <strong>{{ __('messages.name') }}:</strong> {{ $customer->display_name }} <br>
                        </p>
                        <p class="mb-1">
                            <strong>{{ __('messages.phone') }}:</strong> {{ $customer->phone }} <br>
                        </p>
                        <p class="mb-1">
                            <strong>{{ __('messages.email') }}:</strong> {{ $customer->email }} <br>
                        </p>
                        <p>
                            <strong>{{ __('messages.billing') }}:s</strong> {{ $customer->displayLongAddress('billing') }}
                        </p>
                    </div>

                    <div class="col-3 col-md-3 mt-4 mb-4">
                        <h5>{{ __('messages.guarantor_details') }}</h5>
                        <p class="mb-1">
                            <strong>{{ __('messages.name') }}:</strong> {{ $customer->guarantors->display_name }} <br>
                        </p>
                        <p class="mb-1">
                            <strong>{{ __('messages.phone') }}:</strong> {{ $customer->guarantors->phone }} <br>
                        </p>
                        <p>
                            <strong>{{ __('messages.billing') }}:</strong> {{ $customer->guarantors->displayLongAddress('gurantor') }}
                        </p>
                    </div>
                    <div class="col-3 col-md-3 mt-4 mb-4">
                        <h5>{{ __('messages.standings') }}</h5>
                        <p class="mb-1">
                            <strong>{{ __('messages.due_amount') }}</strong><br>
                        </p>
                        <p class="mb-1">
                         <b> {{  $totalDue }}</b>
                        </p>
                    </div>
                    <div class="col-3 col-md-3 text-right mt-4 mb-4">
                        <a href="{{ route('customers.edit', ['customer' => $customer->id, 'company_uid' => $currentCompany->uid]) }}"
                            class="btn btn-primary">
                            <i class="material-icons">edit</i>
                            {{ __('messages.edit') }}
                        </a>
                        <a href="{{ route('customers.delete', ['customer' => $customer->id, 'company_uid' => $currentCompany->uid]) }}"
                            class="btn btn-danger delete-confirm">
                            <i class="material-icons">delete</i>
                            {{ __('messages.delete') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 order-1 order-md-2">
            <nav class="nav nav-pills nav-justified w-100" role="tablist">
                <a href="#loans" class="h6 nav-item nav-link bg-secondary text-white active show" data-toggle="tab"
                    role="tab" aria-selected="true">{{ __('messages.loans') }}</a>
                <a href="#payments" class="h6 nav-item nav-link bg-secondary text-white" data-toggle="tab" role="tab"
                    aria-selected="false">{{  __('messages.repayments') }}</a>
            </nav>

            <div class="tab-content">
                <div class="tab-pane active show" id="loans">
                    <div class="card">

                        @if ($loans->count() > 0)
                            <div class="card-header">
                                <h3>{{ __('messages.loans') }}</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-xl mb-0 thead-border-top-0 table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.reference_number') }}</th>
                                            <th>{{ __('messages.date') }}</th>
                                            <th>{{ __('messages.due_date') }}</th>
                                            <th>{{ __('messages.customer') }}</th>
                                            <th>{{ __('messages.amount') }}</th>
                                            <th>{{ __('messages.due_amount') }}</th>
                                            <th>{{ __('messages.status') }}</th>
                                            <th class="w-50px">{{ __('messages.view') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="loans">
                                        @foreach ($loans as $loan)
                                            <tr>
                                                <td>
                                                    {{ $loan->reference_number }}
                                                </td>
                                                <td>
                                                    {{ $loan->loan_date }}
                                                </td>
                                                <td>
                                                    {{ $loan->return_date }}
                                                </td>
                                                <td>
                                                    {{ $loan->customer->display_name }}
                                                </td>
        
                                                <td>
                                                    {{ currencyFormat($loan->amount, $loan->currency->symbol) }}
                                                </td>
                                                {{-- <td>
                                                    {{ currencyFormat($loan->totalPaid($loan->id), $loan->currency->symbol) }}
                                                </td> --}}
                                                <td>
                                                    {{ currencyFormat($loan->amount - $loan->totalPaid($loan->id), $loan->currency->symbol) }}
                                                </td>
                                                <td>
                                                    <div class="badge badge-danger fs-0-9rem">
                                                        {{ $loan->status }}
                                                    </div>
                                                </td>
                                                <td class="h6  d-inline-flex">
        
        
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                <div class="tab-pane" id="payments">
                    <div class="card">
                        @if ($payments->count() > 0)
                            <div class="card-header">
                                <h3>{{ __('messages.repayments') }}</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0 thead-border-top-0 table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.payment_#') }}</th>
                                            <th>{{ __('messages.date') }}</th>
                                            <th>{{ __('messages.customer') }}</th>
                                            <th>{{ __('messages.payment_type') }}</th>
                                            <th>{{ __('messages.reference_number') }}</th>
                                            <th>{{ __('messages.amount') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list" id="payments">
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td>
                                                    {{ $payment_prefix . '-' . $payment->payment_number }}
                                                </td>
                                                <td>
                                                    {{ $payment->payment_date }}
                                                </td>
                                                <td>
                                                    {{ $customer->display_name }}
                                                </td>
                                                <td>
                                                    {{ $payment->payment_method ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $payment->reference_number }}
                                                </td>
                                                <td>
                                                    {{ currencyFormat($payment->amount, $payment->currency_code) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
        </div>
    </div>
@endsection
