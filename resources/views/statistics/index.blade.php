@extends('layouts.app', ['title' => __('Statistik')])

@section('content')
@include('users.partials.header', ['title' => __('Statistik')])

<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-lg-6">
			<div class="mb-3">
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
						<div class="bg-secondary my-3 p-3">
							<canvas id="alumniChart"></canvas>
						</div>
						<p class="mt-3 mb-0 text-muted text-sm">
							<span class="text-nowrap">Terbagi menjadi </span>
						</p>
						<ul class="text-sm pl-3">
							<li>
								<a class="text-success" href="{{ route('user.index').'?alumnistatus=aktif' }}" target="_blank">
									Alumni aktif : <strong>{{ $active }}</strong>
								</a>
							</li>
							<li>
								<a href="{{ route('user.index').'?alumnistatus=belum_aktif' }}" class="text-yellow"  target="_blank">
									Alumni belum aktif : <strong>{{ $notActiveYet }}</strong>
								</a>
							</li>
							<li>
								<a href="{{ route('user.index').'?alumnistatus=tidak_aktif' }}" class="text-danger" target="_blank">
									Alumni tidak aktif : <strong>{{ $notActive }}</strong>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="mb-3">
				<div class="card card-stats mb-4 mb-xl-0">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-0">Jumlah Lulusan 5 Tahun Terakhir</h5>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-primary text-white rounded-circle shadow">
									<i class="fas fa-user-graduate"></i>
								</div>
							</div>
						</div>
						<div class="bg-secondary my-3 p-3">
							<canvas id="gradChart"></canvas>
						</div>
						<p class="mt-3 mb-0 text-muted text-sm">
							<span class="text-nowrap">Terbagi menjadi </span>
						</p>
						<ul class="text-sm pl-3">
							@foreach ($grads as $g)
							<li>
								<a href="{{ route('user.index').'?tahun='.$g->grad }}" target="_blank">
									Tahun {{ $g->grad }} : <strong>{{ $g->total }}</strong>
								</a>
							</li>
							@endforeach
						</ul>
					</div>

					<div class="card-footer text-center">
					    <a href="{{ route('statistic.grad') }}" target="_blank">Lihat lebih detail</a>
					</div>
				</div>
			</div>
			<div class="mb-3">
				<div class="card card-stats mb-4 mb-xl-0">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-0">Asal Alumni</h5>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-purple text-white rounded-circle shadow">
									<i class="fas fa-map"></i>
								</div>
							</div>
						</div>
						<div class="bg-secondary my-3 p-3">
							<canvas id="originChart"></canvas>
						</div>
						<p class="mt-3 mb-0 text-muted text-sm">
							<span class="text-nowrap">Terbagi menjadi </span>
						</p>
						<ul class="text-sm pl-3">
							@foreach ($origin as $d)
							<li>
								<a href="{{ route('user.index').'?asal='.$d->district }}" target="_blank">
									{{ $d->getDistricts() }} : <strong>{{ $d->total }}</strong>
								</a>
							</li>
							@endforeach
						</ul>
					</div>

					<div class="card-footer text-center">
					    <a href="{{ route('statistic.origin') }}" target="_blank">Lihat lebih detail</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="mb-3">
				<div class="card card-stats mb-4 mb-xl-0">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-0">Jurusan dengan Alumni Terbanyak</h5>
								@if ($departments->count() != 0)
								<span class="h2 font-weight-bold mb-0">{{ $departments->first()->department }} </span>
								@endif
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-success text-white rounded-circle shadow">
									<i class="fas fa-book-open"></i>
								</div>
							</div>
						</div>
						<div class="bg-secondary my-3 p-3">
							<canvas id="departmentChart"></canvas>
						</div>
						<p class="mt-3 mb-0 text-muted text-sm">
							<span class="text-nowrap">Dengan rincian </span>
						</p>
						<ul class="text-sm pl-3">
							@foreach ($departments as $d)
							<li>
								<a href="{{ route('user.index').'?jurusan='.$d->department }}" target="_blank">
									{{ $d->department }} : <strong>{{ $d->total }}</strong>
								</a>
							</li>
							@endforeach
						</ul>
					</div>

					<div class="card-footer text-center">
					    <a href="{{ route('statistic.department') }}" target="_blank">Lihat lebih detail</a>
					</div>
				</div>
			</div>
			<div class="mb-3">
				<div class="card card-stats mb-4 mb-xl-0">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-0">Status Lulusan Alumni</h5>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-warning text-white rounded-circle shadow">
									<i class="fas fa-wrench"></i>
								</div>
							</div>
						</div>
						<div class="bg-secondary my-3 p-3">
							<canvas id="statusChart"></canvas>
						</div>
						<p class="mt-3 mb-0 text-muted text-sm">
							<span class="text-nowrap">Dengan rincian </span>
						</p>
						<ul class="text-sm pl-3">
							@foreach ($statuses as $s)
							<li>
								<a href="{{ route('user.index').'?status='.$s->id }}" target="_blank">
									{{ $s->status }} : <strong>{{ $s->total }}</strong>
								</a>
							</li>
							@endforeach
						</ul>
					</div>

					<div class="card-footer text-center">
					    <a href="{{ route('statistic.status') }}" target="_blank">Lihat lebih detail</a>
					</div>
				</div>
			</div>
			<div class="mb-3">
				<div class="card card-stats mb-4 mb-xl-0">
					<div class="card-body">
						<div class="row">
							<div class="col">
								<h5 class="card-title text-uppercase text-muted mb-0">Jenis Kelamin</h5>
							</div>
							<div class="col-auto">
								<div class="icon icon-shape bg-info text-white rounded-circle shadow">
									<i class="fas fa-user"></i>
								</div>
							</div>
						</div>
						<div class="bg-secondary my-3 p-3">
							<canvas id="genderChart"></canvas>
						</div>
						<p class="mt-3 mb-0 text-muted text-sm">
							<span class="text-nowrap">Dengan rincian </span>
						</p>
						<ul class="text-sm pl-3">
							@foreach ($gender as $g)
							<li>
								<a href="{{ route('user.index').'?gender='.$g->gender }}" target="_blank">
									{{ $g->gender == 'M' ? 'Laki-laki' : 'Perempuan' }} : <strong>{{ $g->total }}</strong>
								</a>
							</li>
							@endforeach
						</ul>
					</div>

					<div class="card-footer text-center">
					    <a href="{{ route('statistic.gender') }}" target="_blank">Lihat lebih detail</a>
					</div>
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
		function randomColor() {
			return Math.round(Math.random()*255)+','+Math.round(Math.random()*255)+','+Math.round(Math.random()*255);
		}

		var ctx = $('#alumniChart');
		var labels = [ 'Alumni Aktif', 'Alumni Belum AKtif', 'Alumni Tidak Aktif' ];
		var datas = [ {{ $active.','.$notActiveYet.','.$notActive }} ];
		var borderColors = [ 'rgb(36,164,109)','rgb(255,214,0)','rgb(236,12,56)' ];
		var backgrounds = [ 'rgb(36,164,109,0.2)','rgb(255,214,0,0.2)','rgb(236,12,56,0.2)' ];

		var alumniChart = new Chart(ctx, {        	
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

		ctx = $('#departmentChart');
		labels = [ @foreach ($departments as $d) '{{ $d->department }}', @endforeach ];
		datas = [ @foreach ($departments as $d) {{ $d->total.',' }} @endforeach ];
		var color = [ @foreach ($departments as $d) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		borderColors = [];		
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var departmentChart = new Chart(ctx, {        	
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

		ctx = $('#originChart');
		labels = [ @foreach ($origin as $d) '{{ $d->getDistricts() }}', @endforeach ];
		datas = [ @foreach ($origin as $d) {{ $d->total.',' }} @endforeach ];
		color = [ @foreach ($origin as $d) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		borderColors = [];		
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var originChart = new Chart(ctx, {        	
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

		ctx = $('#statusChart');
		labels = [ @foreach ($statuses as $s) '{{ $s->status }}', @endforeach ];
		datas = [ @foreach ($statuses as $s) {{ $s->total.',' }} @endforeach ];
		color = [ @foreach ($statuses as $s) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
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

		ctx = $('#gradChart');
		labels = [ @foreach ($grads as $g) 'Tahun {{ $g->grad }}', @endforeach ];
		datas = [ @foreach ($grads as $g) {{ $g->total.',' }} @endforeach ];
		color = [ @foreach ($grads as $g) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		borderColors = [];		
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var gradChart = new Chart(ctx, {        	
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

		ctx = $('#genderChart');
		labels = [ @foreach ($gender as $g) '{{ $g->gender == 'M' ? 'Laki-laki' : 'Perempuan' }}', @endforeach ];
		datas = [ @foreach ($gender as $g) {{ $g->total.',' }} @endforeach ];
		color = [ @foreach ($gender as $g) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		backgrounds = [];
		borderColors = [];		
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var genderChart = new Chart(ctx, {        	
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