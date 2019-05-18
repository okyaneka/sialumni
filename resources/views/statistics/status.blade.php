@extends('layouts.app', ['title' => __('Status')])

@section('content')
@include('users.partials.header', ['title' => __('Status')])

<div class="container-fluid mt-5">
	<div class="row align-items-center">
		{{-- By Alumnus --}}
		<div class="col-lg-8 offset-lg-2 mb-5">
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
									<th scope="col">Status</th>
									<th scope="col" class="text-right">Jumlah</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($statistics as $data)
								<tr>
									<td>{{ App\Status::where('code', $data->Status)->first()->status }}</td>
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
		var labels = [ @foreach ($statistics as $data) 
		@if (is_null(App\Status::where('code', $data['Status'])->first()))
		'{{ 'Invalid' }}'
		@else
		'{{ App\Status::where('code', $data['Status'])->first()->status }}'
		@endif, 
		@endforeach ];
		var datas = [ @foreach ($statistics as $data) {{ $data['Jumlah'].',' }} @endforeach ];
		var color = [ @foreach ($statistics as $data) '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}', @endforeach ];
		var backgrounds = [];
		var borderColors = [];		
		for (var i = 0; i < color.length; i++) {
			backgrounds[i] = 'rgba('+color[i]+',0.2)';
		}
		for (var i = 0; i < color.length; i++) {
			borderColors[i] = 'rgb('+color[i]+')';
		}

		var statistics = new Chart(ctx, {        	
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