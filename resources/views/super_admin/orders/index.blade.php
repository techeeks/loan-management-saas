@extends('layouts.app', ['page' => 'super_admin.payment'])

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
    <div class="card">
        @include('super_admin.orders._table')
    </div>
@endsection
