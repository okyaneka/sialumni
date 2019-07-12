<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/">Home</a></li>
		@if (Route::is('job.showall'))
		{{-- expr --}}
		<li class="breadcrumb-item active" aria-current="page">Job</li>
		@else
		<li class="breadcrumb-item"><a href="{{ route('job.showall') }}">Job</a></li>
		<li class="breadcrumb-item active" aria-current="page">{{ $job }}</li>
		@endif
	</ol>

</nav>
