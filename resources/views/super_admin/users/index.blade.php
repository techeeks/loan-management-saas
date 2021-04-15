@extends('layouts.app', ['page' => 'super_admin.users'])

@section('title', __('messages.users'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.users') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.users') }}</h1>
        </div>
        <a href="{{ route('super_admin.users.create') }}" class="btn btn-success ml-3"><i class="material-icons">add</i> {{ __('messages.add_user') }}</a>
    </div>
@endsection

@section('content')
    @include('super_admin.users._filters')

    <div class="card">
        @include('super_admin.users._table')
    </div>
@endsection
