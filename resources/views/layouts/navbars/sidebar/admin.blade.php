<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand py-3" href="{{ route('home') }}">
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
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main"
                        aria-expanded="false" aria-label="Toggle sidenav">
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
                <a href="#alumni" class="nav-link {{ Request::is('user*') ? 'active' : '' }}" data-toggle="collapse" role="button" aria-expanded="true">
                    <i class="ni ni-hat-3 text-orange"></i> {{ __('Alumni') }}
                </a>

                <div id="alumni" class="collapse bg-secondary {{ Request::is('user*') || Request::is('batch/user') ? 'show' : '' }}">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
                            <a href="{{ route('user.index') }}" class="nav-link">Daftar alumni</a>
                        </li>
                        <li class="nav-item {{ Request::is('batch/user') ? 'active' : '' }}">
                            <a href="{{ route('user.batch') }}" class="nav-link">Batch alumni</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="#job" class="nav-link {{ Request::is('job*') ? 'active' : '' }}" data-toggle="collapse" role="button" aria-expanded="true">
                    <i class="fas fa-briefcase text-pink"></i> Lowongan Kerja
                </a>

                <div id="job" class="collapse bg-secondary {{ Request::is('job*') ? 'show' : '' }}">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item {{ Request::is('job/index') ? 'active' : '' }}">
                            <a href="{{ route('job.index') }}" class="nav-link">Daftar lowongan</a>
                        </li>
                        <li class="nav-item {{ Request::is('job/create') ? 'active' : '' }}">
                            <a href="{{ route('job.create') }}" class="nav-link">Buat lowongan</a>
                        </li>
                    </ul>
                </div>
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
                <a class="nav-link {{ Request::is('department*') || Request::is('status*') || Request::is('group*') ? 'active' : '' }}" href="#master-data" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="master-data">
                    <i class="ni ni-folder-17 text-blue"></i> {{ __('Master Data') }}
                </a>

                <div class="collapse {{ Request::is('department*') || Request::is('status*') || Request::is('group*') ? 'show' : '' }} bg-secondary" id="master-data">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item {{ Request::is('department*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('department.index') }} ">Jurusan</a>
                        </li>
                        <li class="nav-item {{ Request::is('status*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('status.index') }}">Status pekerjaan</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('download*') ? 'active' : '' }}" href="{{ route('download') }}">
                    <i class="ni ni-cloud-download-95 text-yellow"></i> {{ __('Pusat Donwload') }}
                </a>
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
</nav>
