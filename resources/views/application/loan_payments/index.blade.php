@extends('layouts.app', ['page' => 'payments'])

@section('title', __('messages.payments'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.payments') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.payments') }}</h1>
        </div>
    </div>
@endsection

@section('content')
    <form name="LoanRequestForm" id="LoanRequestForm" action="{{ route('loan.payments', ['company_uid' => $currentCompany->uid]) }}" method="GET">
        @include('layouts._form_errors')
    
        <div class="card card-form">
            <div class="row no-gutters card-form__body card-body bg-white">
                <div class="col-md-4 pr-4 pl-4">
                    <div class="form-group">
                        <label for="customer">{{ __('messages.customer') }}</label>
                        <select  name="customer" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="customer" required>
                            <option disabled selected>{{ __('messages.select_customer') }}</option>
                            
                            @foreach($customers as $customer)
                                <option {{ Request::has('customer') && $customer->id==Request::get('customer')?'selected':'' }} value="{{ $customer->id }}">{{ $customer->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 pr-4 pl-4">
                    <div class="form-group">
                        <label for="loan">{{ __('messages.loan') }}</label>
                        <select  name="loan" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="loan" required>
                            <option disabled selected>{{ __('messages.loan') }}</option>
                            
                            @foreach($loans as $loan)
                                <option {{ Request::has('loan') && $loan->id==Request::get('loan')?'selected':'' }} value="{{ $loan->id }}">{{ $loan->reference_number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group">
                        <label for="from_date">{{ __('messages.from_date') }}</label>
                        <input name="from_date" type="text" class="form-control input" data-toggle="flatpickr" data-flatpickr-default-date="{{  Request::get('from_date') }}"  required>
                    </div>
                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group">
                        <label for="to_date">{{ __('messages.to_date') }}</label>
                        <input name="to_date" type="text" class="form-control input"  data-toggle="flatpickr" data-flatpickr-default-date="{{  Request::get('to_date') }}"  required>
                    </div>
                </div>
                <div class="col-12 text-center float-right mt-3">
                    <button type="submit" class="btn btn-primary save_form_button">{{ __('messages.search') }}</button>
                    <a href="{{route('loan.payments', ['company_uid' => $currentCompany->uid]) }}" class="btn btn-danger">{{ __('messages.reset_filters') }}</a>
                </div>
            </div>
        </div>
    </form>
    <div class="card">
        @include('application.loan_payments._table')
    </div>
@endsection
