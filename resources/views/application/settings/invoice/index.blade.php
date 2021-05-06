@extends('layouts.app', ['page' => 'settings'])

@section('title', __('messages.invoice_settings'))
    
@section('content')
    <div class="page__heading">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">business</i></a></li>
                <li class="breadcrumb-item">{{ __('messages.settings') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.invoice_settings') }}</li>
            </ol>
        </nav>
        <h1 class="m-0">{{ __('messages.invoice_settings') }}</h1>
    </div>

    <div class="row">
        <div class="col-lg-3">
            @include('application.settings._aside', ['tab' => 'invoice'])
        </div>
        <div class="col-lg-9">
            
            <div class="card card-form">
                <div class="row no-gutters">
                    <div class="col card-form__body card-body bg-white">
                        <form action="{{ route('settings.invoice.update', ['company_uid' => $currentCompany->uid]) }}" method="POST">
                            @include('layouts._form_errors')
                            @csrf

                            <div class="form-group mb-4">
                                <p class="h5 mb-0">
                                    <strong class="headings-color">{{ __('messages.invoice_settings') }}</strong>
                                </p>
                                <p class="text-muted">{{ __('messages.customize_invoice_settings') }}</p>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-5">
                                    <div class="form-group required">
                                        <label for="invoice_prefix">{{ __('messages.invoice_prefix') }}</label>
                                        <input name="invoice_prefix" type="text" class="form-control" value="{{ $currentCompany->getSetting('invoice_prefix') }}" placeholder="{{ __('messages.invoice_prefix') }}">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="invoice_auto_archive">{{ __('messages.auto_archive') }}</label><br>
                                        <div class="custom-control custom-checkbox-toggle custom-control-inline mr-1">
                                            <input type="checkbox" name="invoice_auto_archive" id="invoice_auto_archive" {{ $currentCompany->getSetting('invoice_auto_archive') ? 'checked' : '' }} class="custom-control-input">
                                            <label class="custom-control-label" for="invoice_auto_archive">{{ __('messages.yes') }}</label>
                                        </div>
                                        <label for="invoice_auto_archive" class="mb-0">{{ __('messages.yes') }}</label>
                                        <small class="form-text text-muted">
                                            {{ __('messages.auto_archive_description') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-5">
                                    <div class="form-group required">
                                        <label for="invoice_color">{{ __('messages.invoice_color') }}</label>
                                        <input name="invoice_color" type="color" class="form-control" value="{{ $currentCompany->getSetting('invoice_color') }}" placeholder="{{ __('messages.invoice_color') }}">
                                    </div>
                                </div>
                            </div> 

                            <div class="form-group">
                                <label for="invoice_footer">{{ __('messages.footer') }}</label>
                                <textarea name="invoice_footer" class="form-control" rows="4" placeholder="{{ __('messages.footer') }}">{{ $currentCompany->getSetting('invoice_footer') }}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="invoice_template">Invoice Template</label>
                                                                <div class="row mt-3">
                                                                            <div class="col-md-3">
                                            <div class="custom-control custom-radio image-checkbox">
                                                <input type="radio" class="custom-control-input" id="template_1" name="invoice_template" value="template_1" checked="">
                                                <label class="custom-control-label" for="template_1">
                                                    <img src="http://saasfoxtrot.varuscreative.com/assets/images/templates/invoice/template_1.png" class="img-fluid modal-image">
                                                    <span>Template 1</span>
                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-3">
                                            <div class="custom-control custom-radio image-checkbox">
                                                <input type="radio" class="custom-control-input" id="template_2" name="invoice_template" value="template_2">
                                                <label class="custom-control-label" for="template_2">
                                                    <img src="http://saasfoxtrot.varuscreative.com/assets/images/templates/invoice/template_2.png" class="img-fluid modal-image">
                                                    <span>Template 2</span>
                                                </label>
                                            </div>
                                        </div>
                                                                            <div class="col-md-3">
                                            <div class="custom-control custom-radio image-checkbox">
                                                <input type="radio" class="custom-control-input" id="template_3" name="invoice_template" value="template_3">
                                                <label class="custom-control-label" for="template_3">
                                                    <img src="http://saasfoxtrot.varuscreative.com/assets/images/templates/invoice/template_3.png" class="img-fluid modal-image">
                                                    <span>Template 3</span>
                                                </label>
                                            </div>
                                        </div>
                                                                    </div>
                            </div>
                            <div class="form-group text-right mt-4">
                                <button type="submit" class="btn btn-primary">{{ __('messages.update_settings') }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

