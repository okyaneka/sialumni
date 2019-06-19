@extends('layouts.app', ['title' => __('Pengaturan')])

@section('content')
@include('users.partials.header', ['title' => __('Pengaturan')])

<div class="container-fluid mt-5">
	@if (session('status'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{ session('status') }}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif

	<div class="row align-items-center">
		<div class="col mb-5">
			<form method="post" action="{{ route('setting.set') }}" autocomplete="off">
				@csrf @method('put')
				<div class="pl-lg-4">
					<div class="form-group{{ $errors->has('defaultpassword') ? ' has-danger' : '' }}">
						<label class="form-control-label" for="input-defaultpassword">Password bawaan</label>
						<input type="text" name="defaultpassword" id="input-defaultpassword" class="form-control form-control-alternative{{ $errors->has('defaultpassword') ? ' is-invalid' : '' }}" placeholder="Password bawaan" value="{{ old('defaultpassword', isset($defaultpassword) ? $defaultpassword : '') }}" required>
						@if ($errors->has('defaultpassword'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('defaultpassword') }}</strong>
						</span> @endif
					</div>

					<div class="form-group{{ $errors->has('grouplink') ? ' has-danger' : '' }}">
						<label class="form-control-label" for="input-grouplink">Link grup telegram</label>
						<input type="text" name="grouplink" id="input-grouplink" class="form-control form-control-alternative{{ $errors->has('grouplink') ? ' is-invalid' : '' }}" placeholder="Link grup telegram" value="{{ old('grouplink', isset($grouplink) ? $grouplink : '') }}" required>
						@if ($errors->has('grouplink'))
						<span class="invalid-feedback" role="alert">
							<strong>{{ $errors->first('grouplink') }}</strong>
						</span> @endif
					</div>

					<div class="text-center">
						<button type="submit" class="btn btn-success mt-4">{{ __('Update') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	@include('layouts.footers.auth')
</div>
@endsection