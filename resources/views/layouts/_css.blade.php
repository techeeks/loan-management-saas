<!-- Stylesheets -->
<link type="text/css" href="{{ asset('assets/vendor/simplebar.min.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/app.css?v=1.0.0') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/vendor-material-icons.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/vendor-fontawesome-free.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/vendor-select2.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/vendor-flatpickr.css') }}" rel="stylesheet">
<link type="text/css" href="{{ asset('assets/css/vendor-flatpickr-airbnb.css') }}" rel="stylesheet">

@if(get_system_setting('application_favicon'))
<!-- Favicon -->
<link rel="icon" href="{{ get_system_setting('application_favicon') }}">
@endif

<!-- company based preferences -->
@shared
<!-- END company based preferences -->

<!-- page based scripts & styles -->
@yield('page_head_scripts')
<!-- END page based scripts & styles -->
