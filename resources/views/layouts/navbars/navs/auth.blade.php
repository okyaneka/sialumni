<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <div class="breadcrumb bg-transparent">
            @if (Route::is('home'))
                <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
            @else                
                <a class="h4 mb-0 text-light breadcrumb-item text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                @if (Route::is('profile*'))
                    <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('profile') }}">{{ __('Profil') }}</a>
                @elseif (Route::is('user*'))
                    <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('user.index') }}">{{ __('Alumni') }}</a>
                @elseif (Route::is('department*'))
                    <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('department.index') }}">{{ __('Jurusan') }}</a>
                @elseif (Route::is('status*'))
                    <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('status.index') }}">{{ __('Status') }}</a>
                @elseif (Route::is('group*'))
                    <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('group.index') }}">{{ __('Group') }}</a>
                @elseif (Route::is('statistic*'))
                    @if (Route::is('statistic'))
                        <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('statistic.index') }}">{{ __('Statistik') }}</a>
                    @else
                        <a class="h4 mb-0 text-light breadcrumb-item text-uppercase d-none d-lg-inline-block" href="{{ route('statistic.index') }}">{{ __('Statistik') }}</a>
                        @if (Route::is('statistic.last5years'))
                            <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('statistic.last5years') }}">5 Tahun Terakhir</a>
                        @elseif (Route::is('statistic/department'))
                            <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('statistic.department') }}">Jurusan</a>
                        @elseif (Route::is('statistic/status'))
                            <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('statistic.status') }}">Status</a>
                        @elseif (Route::is('statistic/grad'))
                            <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('statistic.grad') }}">Tahun Lulus</a>
                        @elseif (Route::is('statistic/region'))
                            <a class="h4 mb-0 text-white breadcrumb-item active text-uppercase d-none d-lg-inline-block" href="{{ route('statistic.region') }}">Wilayah</a>
                        @endif
                    @endif
                @endif
            @endif
        </div>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/user.png">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>