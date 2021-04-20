@extends('layouts.app', ['page' => 'Loan Requests'])

@section('title', __('messages.create_loan_request'))
 
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('loan.requests', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.loans') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.create_loan_request') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.create_loan_request') }}</h1>
        </div>
    </div>
@endsection
 
@section('content') 
    <form name="LoanRequestForm" id="LoanRequestForm" action="{{ route('loan.requests.store', ['company_uid' => $currentCompany->uid]) }}" method="POST">
        @include('layouts._form_errors')
        @csrf
        
        <div class="card card-form">
            <div class="row no-gutters card-form__body card-body bg-white">
                <div class="col-md-4 pr-4 pl-4">
                    <div class="form-group required">
                        <label for="customer_id">{{ __('messages.customer') }}</label>
                        <select  name="customer_id" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="customer_id" required>
                            <option disabled selected>{{ __('messages.select_customer') }}</option>
                            
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        
                <div class="col-md-4 pr-4 pl-4">
                      <div class="form-group required">
                        <label for="currency_id">{{ __('messages.currency') }}</label>
                        <select required name="currency_id" data-toggle="select" class="form-control select2-hidden-accessible" data-select2-id="currency_id" required>
                            <option disabled selected>{{ __('messages.select_currency') }}</option>
                            @foreach(get_currencies_select2_array() as $option)
                                <option value="{{ $option['id'] }}" {{ $currentCompany->getSetting('currency_id') == $option['id'] ? 'selected=""' : '' }}>{{ $option['text'] }}</option>
                            @endforeach
                        </select>
                    </div>
                   
                </div>

                <div class="col-md-4 pl-4">
                    <div class="form-group required">
                        <label for="amount">{{ __('messages.amount') }}</label>
                        <input name="amount" type="number" class="form-control input"  step="0.01" required>
                    </div>
                   
                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group required">
                        <label for="loan_date">{{ __('messages.loan_date') }}</label>
                        <input name="loan_date" type="text" class="form-control input" data-toggle="flatpickr" data-flatpickr-default-date=" {{ now() }}"  required>
                    </div>
                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group required">
                        <label for="return_date">{{ __('messages.return_date') }}</label>
                        <input name="return_date" type="text" class="form-control input" data-toggle="flatpickr" required>
                    </div>
                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group required">
                        <label for="status">{{ __('messages.status') }}</label>
                       <select class="form-control select" required id="status" name="status">
                           <option value="">Choose Status</option>
                           <option value="Pending">Pending</option>
                           <option value="Overdue">OverDue</option>
                           <option value="Paid">Paid</option>
                       </select>
                    </div>
                </div>
                <div class="col-md-4 pl-4">
                    
                    <div class="form-group required">
                        <label for="description">{{ __('messages.description') }}</label>
                        <textarea name="description" required class="form-control"></textarea>
                    </div>
        
                </div>
                <div class="col-12 text-center float-right mt-3">
                    <button type="submit" class="btn btn-primary save_form_button">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
        
    </form>
@endsection
@push("page_script")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endpush
@section('page_body_scripts')
    <script>
        $(document).ready(function() {
            $("#LoanRequestForm").validate();
        });
    </script>
@endsection