@extends('statistics.part.layout', ['title' => 'Statistik Tahun Lulus'])

@section('tab-1')
<table class="table table-striped table-hover">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($total as $s)
		<tr>
			<td>{{ $s->key }}</td>
			<td class="text-right">{{ $s->total }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection

@section('tab-2')
<table class="table table-striped table-hover">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($five as $s)
		<tr>
			<td>{{ $s->key }}</td>
			<td class="text-right">{{ $s->total }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection

@section('tab-3')
<table class="table table-striped table-hover">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($three as $s)
		<tr>
			<td>{{ $s->key }}</td>
			<td class="text-right">{{ $s->total }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection

@section('tab-4')
<table class="table table-striped table-hover">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Jumlah</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($one as $s)
		<tr>
			<td>{{ $s->key }}</td>
			<td class="text-right">{{ $s->total }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection

@push('js')
<script type="text/javascript">
	$(function () {
		var data = [
			{
				labels: [ @foreach ($total as $d) {{ $d->key.',' }} @endforeach ],
				datas: [ @foreach ($total as $d) {{ $d->total.',' }} @endforeach ]
			},
			{
				labels:[ @foreach ($five as $d) {{ $d->key.',' }} @endforeach ],
				datas:[ @foreach ($five as $d) {{ $d->total.',' }} @endforeach ]
			},
			{
				labels:[ @foreach ($three as $d) {{ $d->key.',' }} @endforeach ],
				datas:[ @foreach ($three as $d) {{ $d->total.',' }} @endforeach ]
			},
			{
				labels:[ @foreach ($one as $d) {{ $d->key.',' }} @endforeach ],
				datas:[ @foreach ($one as $d) {{ $d->total.',' }} @endforeach ]
			}
		];

		var chart = null;

		function generateChart(data) {
			var ctx = $('#chart');
			var color = []
			var backgrounds = [];
			var borderColors = [];
			color[0] = '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}';
			color[1] = '{{ rand(0,255).','.rand(0,255).','.rand(0,255) }}';
			backgrounds[0] = 'rgba('+color[0]+',0.2)';
			borderColors[0] = 'rgb('+color[0]+')';
			borderColors[1] = 'rgb('+color[1]+')';

			return new Chart(ctx, {
				type: 'bar',
				data: {
					labels: data.labels,
					datasets: [{
						label: ['Jumlah Alumni'],
						data: data.datas,
						backgroundColor: backgrounds[0],
						borderColor: borderColors[0],
						borderWidth: 1,
					}, {
						label: 'Jumlah Alumni',
						data: data.datas,
						borderColor: borderColors[1],
						borderWidth: 2,
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
		}

		chart = generateChart(data[0]);

		$('.nav-link[role="tab"]').click(function() {
			if (chart != null) {
				chart.destroy();
			}
			
			chart = generateChart(data[ $(this).attr('href').substr(-1,1) -1 ]);
		})
	});
</script>
@endpush