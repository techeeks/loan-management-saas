<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    @include('layouts._css')
</head>

<body class="layout-fixed">
    <div class="mdk-header-layout js-mdk-header-layout">
        <div id="header" class="mdk-header bg-dark js-mdk-header m-0">
            <div class="mdk-header__bg">
                <div class="mdk-header__bg-front"></div>
                <div class="mdk-header__bg-rear"></div>
            </div>
            <div class="mdk-header__content">
                <div class="navbar navbar-expand-sm navbar-main navbar-light bg-white pr-0 mdk-header--fixed mdk-header--shadow"
                    id="navbar">
                    <div class="container">
                        <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button"
                            data-toggle="sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <a href="/" class="navbar-brand ">
                            @if(get_system_setting('application_logo'))
                                <img class="navbar-brand-icon" src="{{ get_system_setting('application_logo') }}" width="80" alt="{{ get_system_setting('application_name') }}">
                            @else
                                <span>{{ get_system_setting('application_name') }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mdk-header-layout__content page pt-64px">
            <div class="container page__container">
                @yield('content')
            </div>
        </div>
    </div>

    @include('layouts._js')
    @include('layouts._flash')

</body>

</html>
