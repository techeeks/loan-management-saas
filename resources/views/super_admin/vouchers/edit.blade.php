@extends('layouts.app', ['page' => 'super_admin.vouchers'])

@section('title', __('messages.edit_voucher'))
    
@section('page_header')
    <div class="page__heading d-flex align-items-center">
        <div class="flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="material-icons icon-20pt">home</i></a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ route('super_admin.vouchers') }}">{{ __('messages.vouchers') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.edit_voucher') }}</li>
                </ol>
            </nav>
            <h1 class="m-0 h3">{{ __('messages.edit_voucher') }}</h1>
        </div>
    </div>
@endsection
 
@section('content') 
    <form action="{{ route('super_admin.vouchers.update', $voucher->id) }}" method="POST" enctype="multipart/form-data">
        @include('layouts._form_errors')
        @csrf
        
        @include('super_admin.vouchers._form')
    </form>
@endsection

@section('page_body_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $("#VoucherForm").validate();
    });
</script>
@endsection