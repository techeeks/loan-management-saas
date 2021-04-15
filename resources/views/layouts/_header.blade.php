<div id="header" class="mdk-header js-mdk-header m-0">
    <div class="mdk-header__bg">
        <div class="mdk-header__bg-front"></div>
        <div class="mdk-header__bg-rear"></div>
    </div>
    <div class="mdk-header__content">
        <div class="navbar navbar-expand-sm navbar-main navbar-light bg-white pr-0 mdk-header--fixed" id="navbar"
            data-primary="data-primary">
            <div class="container-fluid p-0">
                <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button"
                    data-toggle="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a href="{{ route('dashboard', ['company_uid' => $currentCompany->uid]) }}" class="navbar-brand">
                    @if(get_system_setting('application_logo'))
                        <img class="navbar-brand-icon" src="{{ get_system_setting('application_logo') }}" width="80" alt="{{ get_system_setting('application_name') }}">
                    @else
                        <span>{{ get_system_setting('application_name') }}</span>
                    @endif
                </a>

                <ul class="nav navbar-nav d-none d-sm-flex border-left navbar-height align-items-center">
                    <li class="nav-item dropdown">
                        <a href="#account_menu" class="nav-link dropdown-toggle" data-toggle="dropdown"
                            data-caret="false">
                            <img src="{{ $authUser->avatar }}" class="rounded-circle" width="40" height="40">
                            <span class="ml-1 d-flex-inline">
                                <span class="text-light">{{ $authUser->full_name }}</span>
                            </span>
                        </a>
                        <div id="account_menu" class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-item-text dropdown-item-text--lh">
                                <div><strong>{{ $authUser->full_name }}</strong></div>
                            </div>
                            <div class="dropdown-divider"></div>
                            @if(!$authUser->hasRole('super_admin'))
                                <a class="dropdown-item" href="{{ route('dashboard', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.dashboard') }}</a>
                                <a class="dropdown-item" href="{{ route('settings.company', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.company') }}</a>
                                <a class="dropdown-item" href="{{ route('settings.account', ['company_uid' => $currentCompany->uid]) }}">{{ __('messages.my_profile') }}</a>
                                <div class="dropdown-divider"></div>
                            @else
                                <a class="dropdown-item" href="{{ route('super_admin.users.edit', $authUser->id) }}">{{ __('messages.my_profile') }}</a>
                                <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}">{{ __('messages.logout') }}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
