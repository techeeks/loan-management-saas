@extends('layouts.app', ['page' => 'super_admin.settings.payment'])

@section('title', __('messages.payment_settings'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a>{{ __('messages.payment_settings') }}</a></li>
                </ol>
            </nav>
            <h1 class="m-0 h3">{{ __('messages.payment_settings') }}</h1>
        </div>
    </div>
@endsection

@section('content') 
    <form action="{{ route('super_admin.settings.payment.update') }}" method="POST" enctype="multipart/form-data">
        @include('layouts._form_errors')
        @csrf
        
        @include('super_admin.settings._payment_form')
    </form>
@endsection