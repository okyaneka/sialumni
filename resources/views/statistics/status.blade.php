@extends('statistics.part.layout', ['title' => 'Statistik Berdasarkan Status Pekerjaan'])

@section('tab-1')
<table class="table table-striped table-hover">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			@foreach ($status as $s)
			<th scope="col" class="text-right">{{ $s->status }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach ($total as $d)
		<tr>
			<td>{{ $d->grad }}</td>
			@foreach ($status as $s)
			<?php $k = $s->status; ?>
			<td class="text-right">{{ $d->$k }}</td>
			@endforeach
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
			@foreach ($status as $s)
			<th scope="col" class="text-right">{{ $s->status }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach ($five as $d)
		<tr>
			<td>{{ $d->grad }}</td>
			@foreach ($status as $s)
			<?php $k = $s->status; ?>
			<td class="text-right">{{ $d->$k }}</td>
			@endforeach
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
			@foreach ($status as $s)
			<th scope="col" class="text-right">{{ $s->status }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach ($three as $d)
		<tr>
			<td>{{ $d->grad }}</td>
			@foreach ($status as $s)
			<?php $k = $s->status; ?>
			<td class="text-right">{{ $d->$k }}</td>
			@endforeach
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
			@foreach ($status as $s)
			<th scope="col" class="text-right">{{ $s->status }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach ($one as $d)
		<tr>
			<td>{{ $d->grad }}</td>
			@foreach ($status as $s)
			<?php $k = $s->status; ?>
			<td class="text-right">{{ $d->$k }}</td>
			@endforeach
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
			labels: [ @foreach ($total as $d) {{ $d->grad.',' }} @endforeach ],
			datas: []
		},
		{
			labels: [ @foreach ($five as $d) {{ $d->grad.',' }} @endforeach ],
			datas: []
		},
		{
			labels: [ @foreach ($three as $d) {{ $d->grad.',' }} @endforeach ],
			datas: []
		},
		{
			labels: [ @foreach ($one as $d) {{ $d->grad.',' }} @endforeach ],
			datas: []
		}];

		@foreach ($status as $s)
		<?php $k = $s->status; ?>
		data[0].datas['{{ $k }}'] = [ @foreach ($total as $d) {{ $d->$k.',' }} @endforeach ];
		data[1].datas['{{ $k }}'] = [ @foreach ($five as $d) {{ $d->$k.',' }} @endforeach ];
		data[2].datas['{{ $k }}'] = [ @foreach ($three as $d) {{ $d->$k.',' }} @endforeach ];
		data[3].datas['{{ $k }}'] = [ @foreach ($one as $d) {{ $d->$k.',' }} @endforeach ];
		@endforeach

		function generateChart(data) {
			var ctx = $('#chart');
			var color = []
			var backgrounds = [];
			var borderColors = [];
			var datasets = [];
			
			for (var i = 0; i < Object.keys(data.datas).length; i++) {
				color[i] = Math.round(Math.random()*255)+','+Math.round(Math.random()*255)+','+Math.round(Math.random()*255);
			}
			for (var i = 0; i < color.length; i++) {
				backgrounds[i] = 'rgba('+color[i]+',0.2)';
			}
			for (var i = 0; i < color.length; i++) {
				borderColors[i] = 'rgb('+color[i]+')';
			}
			for (var i = 0; i < Object.keys(data.datas).length; i++) {
				datasets[i] = {
					label: Object.keys(data.datas)[i],
					data: data.datas[Object.keys(data.datas)[i]],
					backgroundColor: backgrounds[i],
					borderColor: borderColors[i],
					borderWidth: 1,
				}
			}

			return new Chart(ctx, {
				type: 'bar',
				data: {
					labels: data.labels,
					datasets: datasets
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

		var chart = generateChart(data[0]);
		$('.nav-link[role="tab"]').click(function() {
			if (chart != null) {
				chart.destroy();
			}

			chart = generateChart(data[ $(this).attr('href').substr(-1,1) -1 ]);
		})
	});
</script>
@endpush