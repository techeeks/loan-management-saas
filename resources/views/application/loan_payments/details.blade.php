@extends('layouts.app', ['page' => 'payments'])

@section('title', __('messages.payment_invoice'))
 
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('payments', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.payments') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.payment_invoice') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.payment_invoice') }}</h1>
        </div>
    </div>
@endsection
 
@section('content') 
    <div class="pdf-iframe">
        <iframe src="{{ route('pdf.payment', ['payment' => $payment->id]) }}" frameborder="0"></iframe>
    </div>
@endsection
