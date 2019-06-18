@extends('statistics.part.layout', ['title' => 'Statistik Berdasarkan Jenis Kelamin'])

@section('tab-1')
<table class="table">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Laki-laki</th>
			<th scope="col" class="text-right">Perempuan</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($total as $s)
		<tr>
			<td>{{ $s->grad }}</td>
			<td class="text-right">{{ $s->M }}</td>
			<td class="text-right">{{ $s->F }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection

@section('tab-2')
<table class="table">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Laki-laki</th>
			<th scope="col" class="text-right">Perempuan</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($five as $s)
		<tr>
			<td>{{ $s->grad }}</td>
			<td class="text-right">{{ $s->M }}</td>
			<td class="text-right">{{ $s->F }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection

@section('tab-3')
<table class="table">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Laki-laki</th>
			<th scope="col" class="text-right">Perempuan</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($three as $s)
		<tr>
			<td>{{ $s->grad }}</td>
			<td class="text-right">{{ $s->M }}</td>
			<td class="text-right">{{ $s->F }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endsection

@section('tab-4')
<table class="table">
	<thead class="thead-light">
		<tr>
			<th scope="col">{{ $key }}</th>
			<th scope="col" class="text-right">Laki-laki</th>
			<th scope="col" class="text-right">Perempuan</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($one as $s)
		<tr>
			<td>{{ $s->grad }}</td>
			<td class="text-right">{{ $s->M }}</td>
			<td class="text-right">{{ $s->F }}</td>
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

		data[0].datas['M'] = [ @foreach ($total as $d) {{ $d->M.',' }} @endforeach ];
		data[1].datas['M'] = [ @foreach ($five as $d) {{ $d->M.',' }} @endforeach ];
		data[2].datas['M'] = [ @foreach ($three as $d) {{ $d->M.',' }} @endforeach ];
		data[3].datas['M'] = [ @foreach ($one as $d) {{ $d->M.',' }} @endforeach ];
		data[0].datas['F'] = [ @foreach ($total as $d) {{ $d->F.',' }} @endforeach ];
		data[1].datas['F'] = [ @foreach ($five as $d) {{ $d->F.',' }} @endforeach ];
		data[2].datas['F'] = [ @foreach ($three as $d) {{ $d->F.',' }} @endforeach ];
		data[3].datas['F'] = [ @foreach ($one as $d) {{ $d->F.',' }} @endforeach ];

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
				if (Object.keys(data.datas)[i] == 'M') {
					var label = 'Laki-laki';
				} else {
					var label = 'Perempuan';
				}
				datasets[i] = {
					label: label,
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