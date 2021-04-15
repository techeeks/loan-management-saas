@extends('layouts.app', ['page' => 'settings'])

@section('title', __('messages.custom_fields'))
    
@section('content')
    <div class="page__heading">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">business</i></a></li>
                <li class="breadcrumb-item">{{ __('messages.settings') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.custom_fields') }}</li>
            </ol>
        </nav>
        <h1 class="m-0">{{ __('messages.custom_fields') }}</h1>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('application.settings._aside', ['tab' => 'custom_fields'])
        </div>
        <div class="col-lg-9">
            <div class="card card-form">
                <div class="row no-gutters">
                    <div class="col card-form__body card-body bg-white">

                        <div class="form-row align-items-center mb-4">
                            <div class="col">
                                <p class="h4 mb-0">
                                    <strong class="headings-color">{{ __('messages.custom_fields') }}</strong>
                                </p>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('settings.custom_fields.create', ['company_uid' => $currentCompany->uid]) }}" class="btn btn-primary text-white">
                                    {{ __('messages.add_custom_field') }}
                                </a>
                            </div>
                        </div>

                        @include('application.settings.custom_field._table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

