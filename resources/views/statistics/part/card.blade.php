<div class="header">
    <div class="header-body">
        <!-- Card stats -->
        <div class="row">
            <div class="mb-3 col-lg-3">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Alumni</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($total) }} </span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-nowrap">Sejak 2018</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-3">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Alumni Terdata</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($inputed) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                    <i class="fas fa-chart-pie"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-warning mr-2"><i class="fas fa-percentage"></i> {{ number_format($inputed/$total*100, 2).'%' }}</span>
                            <span class="text-nowrap">total alumni</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-3">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Alumni Baru</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($this_year) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            @if ($last_year)
                            <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> {{ number_format($this_year/$last_year*100, 2).'%' }}</span>
                            <span class="text-nowrap">tahun terakhir</span> @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-lg-3">
                <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Alumni terbanyak</h5>
                                <span class="h2 font-weight-bold mb-0">{{ number_format($max['count']) }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-nowrap">{{ 'Jurusan '.$max['field'] }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
