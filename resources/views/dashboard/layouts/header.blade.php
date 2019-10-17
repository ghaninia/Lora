<header id="header-container" class="fullwidth dashboard-header not-sticky">
  <!-- Header -->
  <div id="header">
    <div class="container">
      <div class="right-side">
        <div id="logo">
          <a href="{{ route('dashboard.main') }}">
          </a>
        </div>
      </div>
      <!-- right Side Content / End -->
      <!-- left Side Content / End -->
      <div class="left-side">
        <div class="header-widget">
          <div class="credit">
            <i class="icon-line-awesome-money"></i>
            @php($credit = currency(me()->credit) )
            <div class="price">
              <label>{{ trans("dashboard.buy.credit") }}</label>
              <span>{!! $credit > 0 ? sprintf("%s <small>%s</small>"  , number_format($credit['currency']) , $credit['type'] ) : null !!}</span>
            </div>
          </div>
        </div>
        <!-- User Menu -->
        <div class="header-widget">
          <!-- Messages -->
          <div class="header-notifications user-menu">
            <div class="header-notifications-trigger">
              <a href="#"><div class="user-avatar status-online"><img src="{{ avatar() }}" alt=""></div></a>
            </div>

            <!-- Dropdown -->
            <div class="header-notifications-dropdown">

              <!-- User Status -->
              <div class="user-status">

                <!-- User Name / Avatar -->
                <div class="user-details">
                  <div class="user-avatar status-online"><img src="{{ avatar() }}" alt=""></div>
                  <div class="user-name">
                    {{ username() }}
                    <span>{{ auth()->user()->fullname }}</span>
                  </div>
                </div>
            </div>

            <ul class="user-menu-small-nav">
              <li><a href="{{ route('dashboard.profile.index' , ['index' => 'edit']) }}"><i class="icon-material-outline-dashboard"></i>{{ trans("dashboard.profile.edit.text") }}</a></li>
              <li><a href="{{ route('dashboard.profile.index' , ['index' => 'password']) }}"><i class="icon-material-outline-settings"></i>{{ trans("dashboard.profile.changepassword.text") }}</a></li>
              <li class="pointer"><a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="icon-material-outline-power-settings-new"></i>{{ trans('dashboard.profile.logout') }}</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
            </ul>

            </div>
          </div>
        </div>
        <!-- User Menu / End -->
      </div>
      <!-- left Side Content / End -->
    </div>
  </div>
  <!-- Header / End -->
</header>
