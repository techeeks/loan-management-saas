@extends('layouts.app', ['page' => 'super_admin.vouchers'])

@section('title', __('messages.vouchers'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.vouchers') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.vouchers') }}</h1>
        </div>
        <a href="{{ route('super_admin.vouchers.create') }}" class="btn btn-success ml-3"><i class="material-icons">add</i> {{ __('messages.create_voucher') }}</a>
    </div>
@endsection

@section('content')
    <div class="card">
        @include('super_admin.vouchers._table')
    </div>
@endsection
