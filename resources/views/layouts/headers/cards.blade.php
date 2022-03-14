<div class="header pt-5 pt-md-8">
    @if (session('status'))
    <div class="mb-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('status') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
    <div class="header-body">
        <!-- Card stats -->
        <div class="row">
            @if (empty($department) || empty($status))
            <div class="mb-3 col-12">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-2">Master Data Jurusan dan atau
                                    Status Pekerjaan masih kosong</h5>
                                <ul>
                                    <li><a href="{{ route('department.index') }}">Klik link berikut untuk menambahkan
                                            masterdata Jurusan di halaman master data jurusan.</a></li>
                                    <li><a href="{{route('status.index')}}">Klik link berikut untuk menambahkan
                                            masterdata Status Pekerjaan di halaman master data status pekerjaan.</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="mb-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Alumni</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($total) }} </span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('user.index') }}" target="_blank">Lihat detail</a>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Alumni Aktif</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($active) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-warning mr-2"><i class="fas fa-percentage"></i> {{
                                number_format($inputed/$total*100, 2).'%' }}</span>
                            <span class="text-nowrap">total alumni</span>
                        </p> --}}
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('user.index').'?alumnistatus=aktif' }}" target="_blank">Lihat detail</a>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Alumni Belum Aktif</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($notActiveYet) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('user.index').'?alumnistatus=belum_aktif' }}" target="_blank">Lihat detail</a>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Alumni Tidak Aktif</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($notActive) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <p class="mt-3 mb-0 text-muted text-sm">
                            @if ($last_year)
                            <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> {{
                                number_format($this_year/$last_year*100, 2).'%' }}</span>
                            <span class="text-nowrap">tahun terakhir</span> @endif
                        </p> --}}
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('user.index').'?alumnistatus=tidak_aktif' }}" target="_blank">Lihat detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>