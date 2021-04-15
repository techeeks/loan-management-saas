@extends('layouts.auth')

@section('title', __('messages.register'))

@section('content')
<h1 class="text-center h6 mb-4">{{ __('messages.register_welcome') }}</h1>

<form action="{{ route('register') }}" method="POST" novalidate>
    @csrf

    <div class="form-group">
        <label class="text-label" for="first_name">{{ __('messages.first_name') }}:</label>
        <div class="input-group">
            <input id="first_name" name="first_name" type="text"
                class="form-control form-control-prepended @error('first_name') is-invalid @enderror"
                placeholder="{{ __('messages.first_name') }}" value="{{ old('first_name') }}"
                 required>
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="text-label" for="last_name">{{ __('messages.last_name') }}:</label>
        <div class="input-group">
            <input id="last_name" name="last_name" type="text"
                class="form-control form-control-prepended @error('last_name') is-invalid @enderror"
                placeholder="{{ __('messages.last_name') }}" value="{{ old('last_name') }}"
                required>
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="text-label" for="company_name">{{ __('messages.company_name') }}:</label>
        <div class="input-group">
            <input id="company_name" name="company_name" type="text"
                class="form-control form-control-prepended @error('company_name') is-invalid @enderror"
                placeholder="{{ __('messages.company_name') }}" value="{{ old('company_name') }}"
                required>
            @error('company_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="text-label" for="email">{{ __('messages.email') }}:</label>
        <div class="input-group">
            <input id="email" name="email" type="email"
                class="form-control form-control-prepended @error('email') is-invalid @enderror"
                placeholder="user@example.com" value="{{ old('email') }}" autocomplete="email" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="text-label" for="password">{{ __('messages.password') }}:</label>
        <div class="input-group">
            <input id="password" name="password" type="password"
                class="form-control form-control-prepended @error('password') is-invalid @enderror"
                placeholder="{{ __('messages.enter_your_password') }}" required>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label class="text-label" for="password_confirmation">{{ __('messages.confirm_password') }}:</label>
        <div class="input-group">
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="form-control form-control-prepended @error('password_confirmation') is-invalid @enderror"
                placeholder="{{ __('messages.confirm_password') }}" required>
            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <button class="btn btn-block btn-primary" type="submit">{{ __('messages.register') }}</button>
    </div>

    <div class="form-group text-center">
        <a href="{{ route('login') }}">{{ __('messages.login') }}</a> <br>
    </div>
</form>

@endsection