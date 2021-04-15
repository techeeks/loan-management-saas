@extends('layouts.app', ['page' => 'reports.profit_loss'])

@section('title', __('messages.profit_loss_report'))
 
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('reports.profit_loss', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.reports') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.profit_loss_report') }}</li>
                </ol>
            </nav>
            <h1 class="m-0">{{ __('messages.profit_loss_report') }}</h1>
        </div>
    </div>
@endsection 
 
@section('content') 
    <div class="row">
        <div class="col-12 col-md-8">
            <form method="GET">
                <div class="row">
                    <div class="col-12 col-md-4 pl-0 ml-3">
                        <div class="form-group form-inline">
                            <label for="filter[from]">{{ __('messages.from') }}</label>
                            <input name="filter[from]" type="text" class="form-control ml-1" data-toggle="flatpickr"
                                data-flatpickr-default-date="{{ isset(Request::get("filter")['from']) ? Request::get("filter")['from'] : \Carbon\Carbon::now() }}"
                                readonly="readonly" placeholder="{{ __('messages.from') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 pl-0">
                        <div class="form-group form-inline">
                            <label for="filter[to]">{{ __('messages.to') }}</label>
                            <input name="filter[to]" type="text" class="form-control ml-1" data-toggle="flatpickr"
                                data-flatpickr-default-date="{{ isset(Request::get("filter")['to']) ? Request::get("filter")['to'] : \Carbon\Carbon::now()->addMonth() }}"
                                readonly="readonly" placeholder="{{ __('messages.to') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 pl-0">
                        <button type="submit" class="btn btn-light">
                            <i class="material-icons icon-20pt">refresh</i>
                            {{ __('messages.update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-4 text-right">
            <div class="btn-group mb-2">
                <a href="{{ route('reports.profit_loss.pdf', [
                    'company_uid' => $currentCompany->uid,
                    'from' => isset(Request::get("filter")['from']) ? Request::get("filter")['from'] : \Carbon\Carbon::now()->format('Y-m-d'),
                    'to' => isset(Request::get("filter")['to']) ? Request::get("filter")['to'] : \Carbon\Carbon::now()->addMonth()->format('Y-m-d'),
                    'download' => true
                ]) }}" target="_blank" class="btn btn-primary">
                    <i class="material-icons">cloud_download</i>
                    {{ __('messages.download') }}
                </a>
            </div>
        </div>
    </div>
    <div class="pdf-iframe">
        <iframe src="{{ route('reports.profit_loss.pdf', [
            'company_uid' => $currentCompany->uid,
            'from' => isset(Request::get("filter")['from']) ? Request::get("filter")['from'] : \Carbon\Carbon::now()->format('Y-m-d'),
            'to' => isset(Request::get("filter")['to']) ? Request::get("filter")['to'] : \Carbon\Carbon::now()->addMonth()->format('Y-m-d')
        ]) }}" frameborder="0"></iframe>
    </div>
@endsection
