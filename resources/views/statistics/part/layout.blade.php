@extends('layouts.app', ['title' => __($title)])
@section('content')
@include('users.partials.header', ['title' => __($title)])

<div class="container-fluid mt-3">
	<div class="row align-items-center">
		<div class="col-12">
			<div class="nav-wrapper">
				<ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
					<li class="nav-item">
						<a class="nav-link mb-3 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">Keseluruhan</a>
					</li>
					<li class="nav-item">
						<a class="nav-link mb-3" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">5 Tahun Terakhir</a>
					</li>
					<li class="nav-item">
						<a class="nav-link mb-3" id="tabs-icons-text-3-tab" data-toggle="tab" href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3" aria-selected="false">3 Tahun Terakhir</a>
					</li>
					<li class="nav-item">
						<a class="nav-link mb-3" id="tabs-icons-text-4-tab" data-toggle="tab" href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4" aria-selected="false">1 Tahun Terakhir</a>
					</li>
				</ul>
			</div>
			<div class="col-lg-8 offset-lg-2 mb-5">
				<canvas id="chart"></canvas>
			</div>
			<div class="card shadow">
				<div class="card-body">
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
							@yield('tab-1')
						</div>
						<div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
							@yield('tab-2')
						</div>
						<div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel" aria-labelledby="tabs-icons-text-3-tab">
							@yield('tab-3')
						</div>
						<div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
							@yield('tab-4')
						</div>
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
@endpush