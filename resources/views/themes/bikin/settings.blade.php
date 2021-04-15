@extends('layouts.app', ['page' => 'super_admin.settings.theme'])

@section('title', __('messages.edit_theme_settings'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a>{{ __('messages.settings') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.edit_theme_settings') }}</li>
                </ol>
            </nav>
            <h1 class="m-0 h3">{{ __('messages.edit_theme_settings') }}</h1>
        </div>
    </div>
@endsection
 
@section('content') 
    <form action="{{ route('super_admin.settings.theme.update', 'bikin') }}" method="POST" enctype="multipart/form-data">
        @include('layouts._form_errors')
        @csrf
        
        @include('themes.bikin._form')

        <div class="form-group text-center mt-5">
            <button class="btn btn-primary save_form_button">{{ __('messages.save') }}</button>
        </div>
    </form>
@endsection