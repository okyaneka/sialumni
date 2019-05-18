@extends('layouts.app', ['title' => __('Statistik')])

@section('content')
@include('users.partials.header', ['title' => __('Statistik')])

<div class="container-fluid mt-5">
	@include('statistics.part.card')
	<div class="row">
		{{-- By Alumnus --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow text-center">
				<div class="card-header bg-white border-0">
					<div class="col">
						<h3 class="mb-0">{{ __('Jumlah Pendaftar 5 Tahun Terakhir') }}</h3>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byAlumnus"></canvas>
				</div>
				<div class="card-footer text-muted">
					<a href="{{ route('statistic.last5years') }}">Selengkapnya...</a>
				</div>
			</div>
		</div>
		{{-- By Department --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow text-center">
				<div class="card-header bg-white border-0">
					<div class="col">
						<h3 class="mb-0">{{ __('Berdasarkan Jurusan') }}</h3>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byDepartment"></canvas>
				</div>
				<div class="card-footer text-muted">
					<a href="{{ route('statistic.department') }}">Selengkapnya...</a>
				</div>
			</div>
		</div>
		{{-- By Status --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow text-center">
				<div class="card-header bg-white border-0">
					<div class="col">
						<h3 class="mb-0">{{ __('Berdasarkan Status Lulusan') }}</h3>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byStatus"></canvas>
				</div>
				<div class="card-footer text-muted">
					<a href="{{ route('statistic.status') }}">Selengkapnya...</a>
				</div>
			</div>
		</div>
		{{-- By Grad --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow text-center">
				<div class="card-header bg-white border-0">
					<div class="col">
						<h3 class="mb-0">{{ __('Tahun Lulusan') }}</h3>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byGrad"></canvas>
				</div>
				<div class="card-footer text-muted">
					<a href="{{ route('statistic.grad') }}">Selengkapnya...</a>
				</div>
			</div>
		</div>
		{{-- By Region --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow text-center">
				<div class="card-header bg-white border-0">
					<div class="col">
						<h3 class="mb-0">{{ __('Berdasarkan Wilayah') }}</h3>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byRegion"></canvas>
				</div>
				<div class="card-footer text-muted">
					<a href="{{ route('statistic.region') }}">Selengkapnya...</a>
				</div>
			</div>
		</div>
	</div>

	@include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script type="text/javascript">
	$(function () {
		var ctx = $('#byAlumnus');
		var labels = [ @foreach ($by_alumnus as $data) {{ $data['Tahun'].',' }} @endforeach ];
		var datas = [ @foreach ($by_alumnus as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		var color = []
		var backgrounds = [];
		var borderColors = [];
		color[0] = '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}';
		color[1] = '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}';
		backgrounds[0] = 'rgba('+color[0]+',0.2)';
		backgrounds[1] = 'rgba('+color[1]+',0.2)';
		borderColors[0] = 'rgb('+color[0]+')';
		borderColors[1] = 'rgb('+color[1]+')';

		var byAlumnus = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: ['Jumlah Pendaftar'],
					data: datas,
					backgroundColor: backgrounds[0],
					borderColor: borderColors[0],
					borderWidth: 1,
				}, {
					label: 'Jumlah Pendaftar',
					data: datas,
					backgroundColor: backgrounds[1],
					borderColor: borderColors[1],
					type: 'line'
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});

		ctx = $('#byDepartment');
		labels = [ @foreach ($by_department as $data) '{{ $data['Jurusan'] ?: 'Invalid' }}', @endforeach ];
		datas = [ @foreach ($by_department as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_department as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var byDepartment = new Chart(ctx, {        	
			type: 'pie',
			data: {
				labels: labels,
				datasets: [{
					data: datas,
					backgroundColor: backgrounds,
					borderColor: borderColors,
					borderWidth: 1,
				}]
			},
			options : {}
		});

		ctx = $('#byStatus');
		labels = [ @foreach ($by_status as $data) 
		@if (is_null(App\Status::where('code', $data['Status'])->first()))
		'{{ 'Invalid' }}'
		@else
		'{{ App\Status::where('code', $data['Status'])->first()->status }}'
		@endif, 
		@endforeach ];
		datas = [ @foreach ($by_status as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_status as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		
		backgrounds = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var byStatus = new Chart(ctx, {        	
			type: 'pie',
			data: {
				labels: labels,
				datasets: [{
					data: datas,
					backgroundColor: backgrounds,
					borderColor: borderColors,
					borderWidth: 1,
				}]
			},
			options : {}
		});

		ctx = $('#byGrad');
		labels = [ @foreach ($by_grad as $data) '{{ $data['Lulusan'] ?: 'Invalid' }}', @endforeach ];
		datas = [ @foreach ($by_grad as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_grad as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var byGrad = new Chart(ctx, {        	
			type: 'pie',
			data: {
				labels: labels,
				datasets: [{
					data: datas,
					backgroundColor: backgrounds,
					borderColor: borderColors,
					borderWidth: 1,
				}]
			},
			options : {}
		});

		ctx = $('#byRegion');
		labels = [ @foreach ($by_region as $data) '{{ $data['Desa'] ?: 'Invalid' }}', @endforeach ];
		datas = [ @foreach ($by_region as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_region as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var byRegion = new Chart(ctx, {        	
			type: 'pie',
			data: {
				labels: labels,
				datasets: [{
					data: datas,
					backgroundColor: backgrounds,
					borderColor: borderColors,
					borderWidth: 1,
				}]
			},
			options : {}
		});
	});
</script>
@endpush