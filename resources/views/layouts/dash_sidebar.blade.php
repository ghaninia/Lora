<!-- Dashboard Sidebar
================================================== -->
<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">

            <!-- Responsive Navigation Trigger -->
            <a class="dashboard-responsive-nav-trigger">
                <span class="hamburger hamburger--collapse" >
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </span>
                <span class="trigger-title">{{ trans('dash.sidebar.main_menu') }}</span>
            </a>
            
            <!-- Navigation -->
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">
                    
                    <ul data-submenu-title="{{ trans('dash.sidebar.main_menu') }}">

                        <li {{ Hightlight( ['dashboard.main'] ) }}>
                            <a href="{{ route('dashboard.main') }}">
                                <i class="icon-material-outline-dashboard"></i>
                                <span>{{ trans('dash.sidebar.dashboard') }}</span>
                            </a>
                        </li>

                        @access("credit")
                        <li {{ Hightlight( ['dashboard.credit.index' , 'dashboard.credit.BankResponse'] ) }}>
                            <a href="{{ route('dashboard.credit.index') }}">
                                <i class="icon-feather-credit-card"></i>
                                <span>{{ trans('dash.credit.charge.text') }}</span>
                            </a>
                        </li>
                        @endaccess

                        @access("discount")
                        <li {{ Hightlight( ['dashboard.discount.index' , 'dashboard.discount.show'] ) }}>
                            <a href="{{ route('dashboard.discount.index') }}">
                                <i class="icon-material-outline-money"></i>
                                <span>{{ trans('dash.sidebar.discounts') }}</span>
                            </a>
                        </li>
                        @endaccess


                        @access("user")
                        <li {{ Hightlight( ['dashboard.user.index' , 'dashboard.user.edit', 'dashboard.user.create'] ) }}>
                            <a href="{{ route('dashboard.user.index') }}">
                                <i class="icon-material-outline-group"></i>
                                <span>{{ trans('dash.sidebar.users') }}</span>
                            </a>
                        </li>
                        @endaccess
                        @access("permission")
                        <li {{ Hightlight( ['dashboard.permission.index' , 'dashboard.permission.edit', 'dashboard.permission.create'] ) }}>
                            <a href="{{ route('dashboard.permission.index') }}">
                                <i class="icon-material-outline-extension"></i>
                                <span>{{ trans('dash.sidebar.accesses') }}</span>
                            </a>
                        </li>
                        @endaccess
                        @access("role")
                        <li {{ Hightlight( ['dashboard.role.index' , 'dashboard.role.edit', 'dashboard.role.create'] ) }}>
                            <a href="{{ route('dashboard.role.index') }}">
                                <i class="icon-material-outline-business-center"></i>
                                <span>{{ trans('dash.sidebar.roles') }}</span>
                            </a>
                        </li>
                        @endaccess
                        @access("ticket")
                        <li {{ Hightlight( ['dashboard.ticket.index'] ) }}>
                            <a href="{{ route('dashboard.ticket.index') }}">
                                <i class="icon-material-outline-question-answer"></i>
                                <span>{{ trans('dash.sidebar.tickets') }}</span>
                                @php($sideTicketNotRead = \App\Models\Ticket::notRead()->count() )
                                @if( $sideTicketNotRead > 0 )
                                    <span
                                        title="{{ trans('dash.items.new') }}" data-tippy-placement="top" data-tippy-theme="light"
                                        class="nav-tag">{{ $sideTicketNotRead }}</span>
                                @endif
                            </a>
                        </li>
                        @endaccess

                    </ul>

                    @access(['factor.mypayments' , 'factor.payments'] , 'OR')
                    <ul data-submenu-title="{{ trans('dash.sidebar.factor') }}">
                        @access(['factor.mypayments' , 'factor.payments'] , "OR")
                        <li {{ Hightlight( ['dashboard.factor.payments'] ) }}>
                            <a href="{{ route('dashboard.factor.payments') }}">
                                <i class="icon-material-outline-local-atm"></i>
                                <span>{{ trans('dash.sidebar.factor_payment') }}</span>
                            </a>
                        </li>
                        @endaccess
                    </ul>
                    @endaccess
                </div>
            </div>
            <!-- Navigation / End -->

        </div>
    </div>
</div>
<!-- Dashboard Sidebar / End -->
