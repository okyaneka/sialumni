@extends('layouts.app', ['title' => __('Pendaftar 5 Tahun Terakhir')])

@section('content')
@include('users.partials.header', ['title' => __('Pendaftar 5 Tahun Terakhir')])

<div class="container-fluid mt-5">
	<div class="row align-items-center">
		{{-- By Alumnus --}}
		<div class="col-lg-8 offset-lg-2 mb-3">
			<canvas id="chart"></canvas>
		</div>
		<div class="col-12">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="col">
						<h3 class="mb-0">Rincian data</h3>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table bg-white">
							<thead class="thead-light">
								<tr>
									<th scope="col">Tahun</th>
									<th scope="col" class="text-right">Jumlah</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($statistics as $data)
								<tr>
									<td>{{ $data->Tahun }}</td>
									<td class="text-right">{{ $data->Jumlah }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
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
		var ctx = $('#chart');
		var labels = [ @foreach ($statistics as $data) {{ $data['Tahun'].',' }} @endforeach ];
		var datas = [ @foreach ($statistics as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		var color = []
		var backgrounds = [];
		var borderColors = [];
		color[0] = '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}';
		color[1] = '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}';
		backgrounds[0] = 'rgba('+color[0]+',0.2)';
		backgrounds[1] = 'rgba('+color[1]+',0.2)';
		borderColors[0] = 'rgb('+color[0]+')';
		borderColors[1] = 'rgb('+color[1]+')';

		var statistics = new Chart(ctx, {
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
	});
</script>
@endpush