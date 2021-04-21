@extends('layouts.app', ['page' => 'payments'])

@section('title', __('messages.create_payment'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('payments', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.payments') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.create_payment') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.create_payment') }}</h1>
        </div>
    </div>
@endsection
 
@section('content') 
    <form id="LoanPaymentForm" action="{{ route('loan.payments.store', ['loan_id'=>$payment->loan_id,'company_uid' => $currentCompany->uid]) }}" method="POST">
        @include('layouts._form_errors')
        @csrf
        
        @include('application.loan_payments._form')
    </form>
@endsection
@push("page_script")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endpush
@section('page_body_scripts')
    <script>
        $(document).ready(function() {
            $("#LoanPaymentForm").validate();
        });
    </script>
@endsection

