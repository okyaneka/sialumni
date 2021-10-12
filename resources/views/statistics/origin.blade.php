@extends('statistics.part.layout', ['title' => 'Statistik Berdasarkan Asal Kabupaten'])

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
			<td>{{ $s->district }}</td>
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
			<td>{{ $s->district }}</td>
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
			<td>{{ $s->district }}</td>
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
			<td>{{ $s->district }}</td>
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
			labels: [ @foreach ($total as $s) '{{ $s->district }}', @endforeach ],
			datas: [ @foreach ($total as $s) {{ $s->total.',' }} @endforeach ]
		},
		{
			labels:[ @foreach ($five as $s) '{{ $s->district }}', @endforeach ],
			datas:[ @foreach ($five as $s) {{ $s->total.',' }} @endforeach ]
		},
		{
			labels:[ @foreach ($three as $s) '{{ $s->district }}', @endforeach ],
			datas:[ @foreach ($three as $s) {{ $s->total.',' }} @endforeach ]
		},
		{
			labels:[ @foreach ($one as $s) '{{ $s->district }}', @endforeach ],
			datas:[ @foreach ($one as $s) {{ $s->total.',' }} @endforeach ]
		}];

		var chart = null;

		function generateChart(data) {
			var ctx = $('#chart');
			var color = []
			var backgrounds = [];
			var borderColors = [];

			for (var i = 0; i < data.labels.length; i++) {
				color[i] = Math.round(Math.random()*255)+','+Math.round(Math.random()*255)+','+Math.round(Math.random()*255);
			}
			for (var i = 0; i < color.length; i++) {
				backgrounds[i] = 'rgba('+color[i]+',0.2)';
			}
			for (var i = 0; i < color.length; i++) {
				borderColors[i] = 'rgb('+color[i]+')';
			}

			return new Chart(ctx, {        	
				type: 'pie',
				data: {
					labels: data.labels,
					datasets: [{
						data: data.datas,
						backgroundColor: backgrounds,
						borderColor: borderColors,
						borderWidth: 1,
					}]
				},
				options : {}
			});
		}

		chart = generateChart(data[0]);
		$('.nav-link[role="tab"]').click(function() {
			if ( chart != null){
				chart.destroy();
			}
			chart = generateChart(data[ $(this).attr('href').substr(-1,1) -1 ]);
		})
	});
</script>
@endpush