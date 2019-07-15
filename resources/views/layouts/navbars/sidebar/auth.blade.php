<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand py-3" href="/">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>SI Alumni</span>
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('storage/avatars/'.auth()->user()->avatar) }}">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <a href="{{ route('home') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Dashboard</span>
                    </a>
                    @if (!auth()->user()->isAdmin())
                        <a href="{{ route('profile') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Profil Saya</span>
                        </a>
                    @endif
                    <a href="{{ route('setting.get') }}" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Pengaturan</span>
                    </a>
                    <a href="{{ route('larecipe.index') }}" class="dropdown-item" target="_blank">
                        <i class="ni ni-support-16"></i>
                        <span>Bantuan</span>
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
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="/">
                            <i class="fas fa-fw fa-graduation-cap"></i>
                            <span>SI Alumni</span>
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="#profile" data-toggle="collapse" role="button" aria-expanded="true">
                        <i class="ni ni-circle-08 text-pink"></i> {{ __('Profil') }}
                    </a>

                    <div id="profile" class="collapse bg-secondary {{ Request::is('profile*') ? 'show' : '' }}">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('profile') }}">Profil saya</a>
                            </li>
                            <li class="nav-item {{ Request::is('profile/edit') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('profile.edit') }}">Edit profil</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('user*') ? 'active' : '' }}" href="{{ route('user.index') }}">
                        <i class="ni ni-hat-3 text-orange"></i> {{ __('Alumni') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('statistic*') ? 'active' : '' }}" href="#statistic" data-toggle="collapse" role="button" aria-expanded="true">
                        <i class="ni ni-chart-bar-32 text-green"></i> {{ __('Statistik') }}
                    </a>

                    <div id="statistic" class="collapse bg-secondary {{ Request::is('statistic*') ? 'show' : '' }}">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item {{ Request::is('statistic') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('statistic.index') }}">Terkini</a>
                            </li>
                            <li class="nav-item {{ Request::is('statistic/grad') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('statistic.grad') }}">Statistik Lulusan</a>
                            </li>
                            <li class="nav-item {{ Request::is('statistic/origin') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('statistic.origin') }}">Statistik Asal Alumni </a>
                            </li>
                            <li class="nav-item {{ Request::is('statistic/department') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('statistic.department') }}">Statistik Jurusan</a>
                            </li>
                            <li class="nav-item {{ Request::is('statistic/status') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('statistic.status') }}">Statistik Status</a>
                            </li>
                            <li class="nav-item {{ Request::is('statistic/gender') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('statistic.gender') }}">Statistik Jenis Kelamin</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('setting*') ? 'active' : '' }}" href="{{ route('setting.get') }}">
                        <i class="ni ni-settings text-red"></i> {{ __('Pengaturan') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('data*') ? 'active' : '' }}" href="{{ route('larecipe.index') }}" target="_blank">
                        <i class="ni ni-support-16 text-teal"></i> {{ __('Bantuan') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>