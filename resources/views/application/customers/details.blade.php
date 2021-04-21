@extends('layouts.app', ['page' => 'customers'])

@section('title', __('messages.customer_details'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('customers', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.customers') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.customer_details') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.customer_details') }}</h1>
        </div>
    </div>
@endsection
 
@section('content')
    <div class="card">
        <div class="row pl-4 pr-4">
            <div class="col-12 col-md-3 mt-4 mb-4">
                <h5>{{ __('messages.details') }}</h5>
                <p class="mb-1">
                    <strong>{{ __('messages.name') }}:</strong> {{ $customer->display_name }} <br>
                </p>
                <p class="mb-1">
                    <strong>{{ __('messages.contact') }}:</strong> {{ $customer->contact_name }} <br>
                </p>
                <p class="mb-1">
                    <strong>{{ __('messages.email') }}:</strong> {{ $customer->email }} <br>
                </p>
            </div>
            <div class="col-12 col-md-3 mt-4 mb-4">
                <h5>{{ __('messages.billing') }}</h5>
                <p>
                    {{ $customer->displayLongAddress('billing') }}
                </p>
            </div>
            <div class="col-12 col-md-3 text-right mt-4 mb-4"> 
                <a href="{{ route('customers.edit', ['customer' => $customer->id, 'company_uid' => $currentCompany->uid]) }}" class="btn btn-primary">
                    <i class="material-icons">edit</i> 
                    {{ __('messages.edit') }}
                </a>
                <a href="{{ route('customers.delete', ['customer' => $customer->id, 'company_uid' => $currentCompany->uid]) }}" class="btn btn-danger delete-confirm">
                    <i class="material-icons">delete</i> 
                    {{ __('messages.delete') }}
                </a>
            </div>
        </div>
    </div>
@endsection
