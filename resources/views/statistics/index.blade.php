@extends('layouts.app', ['title' => __('Statistik')])

@section('content')
@include('users.partials.header', ['title' => __('Statistik')])

<div class="container-fluid mt-5">
	@include('statistics.part.card')
	<div class="row">
		{{-- By Alumnus --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="mb-0">{{ __('Jumlah Pendaftar 5 Tahun Terakhir') }}</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byAlumnus"></canvas>
				</div>
			</div>
		</div>
		{{-- By Department --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="mb-0">{{ __('Berdasarkan Jurusan') }}</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byDepartment"></canvas>
				</div>
			</div>
		</div>
		{{-- By Status --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="mb-0">{{ __('Berdasarkan Status Lulusan') }}</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byStatus"></canvas>
				</div>
			</div>
		</div>
		{{-- By Grad --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="mb-0">{{ __('Tahun Lulusan') }}</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byGrad"></canvas>
				</div>
			</div>
		</div>
		{{-- By Region --}}
		<div class="col-lg-6 mb-3">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="mb-0">{{ __('Berdasarkan Wilayah') }}</h3>
						</div>
					</div>
				</div>
				<div class="card-body">
					<canvas id="byRegion"></canvas>
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
		var color = '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}';
		var backgrounds = 'rgba('+color+',0.2)';
		var borderColors = 'rgb('+color+')';

		var byAlumnus = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: ['Jumlah Pendaftar'],
					data: datas,
					backgroundColor: backgrounds,
					borderColor: borderColors,
					borderWidth: 1,
				}, {
					label: 'Jumlah Pendaftar',
					data: datas,
					backgroundColor: backgrounds[0],
					borderColor: borderColors[0],
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
		labels = [ @foreach ($by_department as $data) '{{ $data['Jurusan'] }}', @endforeach ];
		datas = [ @foreach ($by_department as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_department as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color+',0.2)';
		}
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color+')';
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
		labels = [ @foreach ($by_status as $data) '{{ App\Status::where('code', $data['Status'])->first()->status }}', @endforeach ];
		datas = [ @foreach ($by_status as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_status as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color+',0.2)';
		}
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color+')';
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

		ctx = $('#byGrad');
		labels = [ @foreach ($by_grad as $data) '{{ $data['Lulusan'] }}', @endforeach ];
		datas = [ @foreach ($by_grad as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_grad as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color+',0.2)';
		}
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color+')';
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

		ctx = $('#byRegion');
		labels = [ @foreach ($by_region as $data) '{{ $data['Desa'] }}', @endforeach ];
		datas = [ @foreach ($by_region as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		color = [ @foreach ($by_region as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color+',0.2)';
		}
		borderColors = [];
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color+')';
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
	});
</script>
@endpush