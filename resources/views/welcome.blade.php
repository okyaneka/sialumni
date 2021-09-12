@extends('layouts.default')

@section('content')
<div class="header bg-gradient-primary py-7 py-lg-8">
    <div id="particles-js"></div>
    <div class="container">
        <div class="header-body text-center mt-7 mb-7">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <h1 class="text-white">{!! __('Selamat Datang di Sistem Informasi Pendataan Alumni<br>SMK Negeri Pringsurat.') !!}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-white p-5 pb-7">
    <div class="container mb-5 text-center">
        <h2 class="display-2 mb-0 text-primary font-weight-bold">Statistik</h2>
    </div>
    
    <div class="d-flex justify-content-center">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-4">
                    <div class="mb-5">
                        <div class="text-center">
                            <h3 class="text-muted">Total Alumni</h3>
                            <h1 class="display-1 text-primary">{{ $data['total'] }}</h1>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="bg-secondary p-3">
                        <canvas id="statusChart"></canvas>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-secondary p-5 pb-7">
    <div class="container mb-5 text-center">
        <h2 class="display-2 mb-0 text-primary font-weight-bold">Info Lowongan Kerja</h2>
    </div>

    <div class="d-flex justify-content-center">
        <div class="container row">
            @if ($data['jobs']->count() == 0)
            <div class="col">
                <h3 class="text-muted text-center">Belum ada info lowongan kerja</h3>
            </div>
            @else
            @foreach ($data['jobs'] as $j)
            <div class="col-md-4 mb-3">
                <div class="card bg-white">
                    <div class="card-body">
                        <h4>{{ $j->position }}</h4>
                        <h3 class="text-primary">{{ $j->company }}</h3>
                        <?php $location = unserialize($j->location);?>
                        <span class="text-muted small">{{ $location['street'] }}, {{ \App\Location::getDistrict($location['district'])->nama }}, {{ \App\Location::getProvince($location['province'])->nama }}</span>
                    </div>
                    <div class="card-footer bg-primary py-2">
                        <h3><a href="{{ route('job.show', $j) }}" class="text-white">lihat detail</a></h3>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="w-100 m-3"></div>
            <div class="col text-center">
                    <a href="{{ route('job.showall') }}" class="btn btn-primary btn-large">Lihat semua lowongan kerja</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="/js/app.js?=v1.0.0"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="/assets/particles.min.js"></script>
<script>
    $( function() {
        /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
        particlesJS.load('particles-js', 'assets/particlesjs-config.json', function() {
            // console.log('callback - particles.js config loaded');
        });

        ctx = $('#statusChart');
        labels = [ @foreach ($data['statuses'] as $s) '{{ $s->status }}', @endforeach ];
        datas = [ @foreach ($data['statuses'] as $s) {{ $s->total.',' }} @endforeach ];
        color = [ @foreach ($data['statuses'] as $s) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
        backgrounds = [];
        borderColors = [];      
        for (var i = 0; i < color.length; i++) {
            backgrounds[i] = 'rgba('+color[i]+',0.2)';
        }
        for (var i = 0; i < color.length; i++) {
            borderColors[i] = 'rgb('+color[i]+')';
        }

        var statusChart = new Chart(ctx, {          
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: datas,
                    backgroundColor: backgrounds,
                    borderColor: borderColors,
                    borderWidth: 2,
                }]
            },
            options : {}
        });
    });
</script>
@endpush