<div class="mdk-drawer js-mdk-drawer" id="default-drawer" data-align="start" data-position="left">
    <div class="mdk-drawer__scrim"></div>
    <div class="mdk-drawer__content">
        <div class="sidebar sidebar-light sidebar-left simplebar" data-simplebar="init">
            <div class="simplebar-wrapper">
                <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                </div>
                <div class="simplebar-mask">
                    <div class="simplebar-offset">
                        <div class="simplebar-content">

                            @if($authUser->hasRole('super_admin'))
                                <div class="sidebar-heading sidebar-m-t">Super Admin Menu</div>
                                <ul class="sidebar-menu">
                                    <li class="sidebar-menu-item {{ $page == 'super_admin.dashboard' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('super_admin.dashboard') }}">
                                            <span class="sidebar-menu-text">{{ __('messages.dashboard') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'super_admin.users' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('super_admin.users') }}">
                                            <span class="sidebar-menu-text">{{ __('messages.users') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'super_admin.plans' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('super_admin.plans') }}">
                                            <span class="sidebar-menu-text">{{ __('messages.plans') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'super_admin.subscriptions' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('super_admin.subscriptions') }}">
                                            <span class="sidebar-menu-text">{{ __('messages.subscriptions') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'super_admin.vouchers' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('super_admin.vouchers') }}">
                                            <span class="sidebar-menu-text">{{ __('messages.vouchers') }}</span>
                                        </a>
                                    </li>
                                   
                                    <li class="sidebar-menu-item {{ $page == 'super_admin.orders' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('super_admin.orders') }}">
                                            <span class="sidebar-menu-text">{{ __('messages.payment') }}</span>
                                        </a>
                                    </li>
                                   
                                    <li class="sidebar-menu-item {{ str_contains($page, 'super_admin.settings.') ? 'active open' : ''}}">
                                        <a class="sidebar-menu-button {{ str_contains($page, 'super_admin.settings.') ? '' : 'collapsed'}}" data-toggle="collapse" href="#settings_menu" aria-expanded="false">
                                            <span class="sidebar-menu-text">{{ __('messages.settings') }}</span>
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu {{ str_contains($page, 'super_admin.settings.') ? 'collapse show' : 'collapse'}}" id="settings_menu" style="">
                                            <li class="sidebar-menu-item {{ $page == 'super_admin.settings.application' ? 'active' : ''}}">
                                                <a class="sidebar-menu-button" href="{{ route('super_admin.settings.application') }}">
                                                    <span class="sidebar-menu-text">{{ __('messages.application_settings') }}</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item {{ $page == 'super_admin.settings.payment' ? 'active' : ''}}">
                                                <a class="sidebar-menu-button" href="{{ route('super_admin.settings.payment') }}">
                                                    <span class="sidebar-menu-text">{{ __('messages.payment') }}</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item {{ $page == 'super_admin.settings.mail' ? 'active' : ''}}">
                                                <a class="sidebar-menu-button" href="{{ route('super_admin.settings.mail') }}">
                                                    <span class="sidebar-menu-text">{{ __('messages.mail_settings') }}</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item {{ $page == 'super_admin.settings.theme' ? 'active' : ''}}">
                                                <a class="sidebar-menu-button" href="{{ route('super_admin.settings.theme', get_system_setting('theme')) }}">
                                                    <span class="sidebar-menu-text">{{ __('messages.theme_settings') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-menu-item d-xl-none d-md-none d-lg-none">
                                        <a class="sidebar-menu-button" href="{{ route('logout') }}">
                                            <span class="sidebar-menu-text">{{ __('messages.logout') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account">
                                    <a href="{{ route('settings.company', ['company_uid' => $currentCompany->uid]) }}" class="flex d-flex align-items-center text-underline-0 text-body">
                                        <span class="avatar mr-3">
                                            <img src="{{ $currentCompany->avatar }}" alt="avatar" class="avatar-img rounded">
                                        </span>
                                        <span class="flex d-flex flex-column">
                                            <strong>{{ $currentCompany->name }}</strong>
                                        </span>
                                    </a>
                                </div>

                                <div class="sidebar-heading sidebar-m-t">Menu</div>
                                <ul class="sidebar-menu">
                                    <li class="sidebar-menu-item {{ $page == 'dashboard' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('dashboard', ['company_uid' => $currentCompany->uid]) }}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i>
                                            <span class="sidebar-menu-text">{{ __('messages.dashboard') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'customers' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('customers', ['company_uid' => $currentCompany->uid]) }}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">account_box</i>
                                            <span class="sidebar-menu-text">{{ __('messages.customers') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'Loans' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('loan.requests', ['company_uid' => $currentCompany->uid]) }}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">book</i>
                                            <span class="sidebar-menu-text">{{ __('messages.loans') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'payments' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('loan.payments', ['company_uid' => $currentCompany->uid]) }}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">payment</i>
                                            <span class="sidebar-menu-text">{{ __('messages.payments') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item ">
                                        <a class="sidebar-menu-button collapsed" data-toggle="collapse" href="#reports_menu" aria-expanded="false">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">pie_chart_outlined</i>
                                            <span class="sidebar-menu-text">Reports</span>
                                            <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                        </a>
                                        <ul class="sidebar-submenu collapse" id="reports_menu" style="">
                                            
                                            <li class="sidebar-menu-item ">
                                                <a class="sidebar-menu-button" href="{{ route('reports.paid.loans', ['company_uid' => $currentCompany->uid])  }}">
                                                    <span class="sidebar-menu-text">{{ __('messages.paid_loans') }}</span>
                                                </a>
                                            </li>
                                            <li class="sidebar-menu-item ">
                                                <a class="sidebar-menu-button" href="{{ route('reports.overdue.loans', ['company_uid' => $currentCompany->uid])  }}">
                                                    <span class="sidebar-menu-text">{{ __('messages.overdue_loans') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="sidebar-menu-item {{ $page == 'settings' ? 'active' : ''}}">
                                        <a class="sidebar-menu-button" href="{{ route('settings.account', ['company_uid' => $currentCompany->uid]) }}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings</i>
                                            <span class="sidebar-menu-text">{{ __('messages.settings') }}</span>
                                        </a>
                                    </li>
                                    <li class="sidebar-menu-item d-xl-none d-md-none d-lg-none">
                                        <a class="sidebar-menu-button" href="{{ route('logout') }}">
                                            <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">exit_to_app</i>
                                            <span class="sidebar-menu-text">{{ __('messages.logout') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="simplebar-placeholder"></div>
            </div>
        </div>
    </div>
</div>
