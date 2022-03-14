@extends('layouts.app', ['title' => __('Pengaturan')])

@section('content')
@include('users.partials.header', ['title' => __('Pengaturan')])

<div class="container-fluid mt-3">
	@if (session('password_status'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{ session('password_status') }}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif

	@if (session('status'))
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		{{ session('status') }}
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	@endif
	<div class="row align-items-center">

		{{-- Profile picture form --}}
		<div class="col-xl-8 mb-5">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="align-items-center">
						<h3 class="mb-0">{{ __('Ubah Avatar') }}</h3>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data">
						@csrf @method('put')

						<div class="form-group">
							<input type="file" class="form-control-file form-group{{ $errors->has('avatar') ? ' has-danger' : '' }}" name="avatar" id="avatar" aria-describedby="fileHelp" accept="image/*">
							<small id="fileHelp" class="form-text text-muted">Silahkan upload file gambar dengan ukuran kurang dari <strong>2MB</strong> dengan dimensi 1:1.</small>
						</div>
						@if ($errors->has('avatar'))
						<span class="invalid-feedback" role="alert" style="display: block;">
						    <strong>{{ $errors->first('avatar') }}</strong>
						</span> 
						@endif
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>

		{{-- Password form --}}
		<div class="col-xl-8 mb-5">
			<div class="card bg-secondary shadow">
				<div class="card-header bg-white border-0">
					<div class="align-items-center">
						<h3 class="mb-0">{{ __('Ubah Password') }}</h3>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="{{ route('profile.password') }}" autocomplete="off">
						@csrf @method('put')

						<h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

						<div class="pl-lg-4">
							<div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
								<label class="form-control-label" for="input-current-password">{{ __('Current Password') }}</label>
								<input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}"
								placeholder="{{ __('Current Password') }}" value="" required>                                
								@if ($errors->has('old_password'))
								<span class="invalid-feedback" role="alert" style="display: block">
									<strong>{{ $errors->first('old_password') }}</strong>
								</span> 
								@endif
							</div>
							<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
								<label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
								<input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}"
								placeholder="{{ __('New Password') }}" value="" required>                                
								@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert" style="display: block">
									<strong>{{ $errors->first('password') }}</strong>
								</span> 
								@endif
							</div>
							<div class="form-group">
								<label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
								<input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative"
								placeholder="{{ __('Confirm New Password') }}" value="" required>
							</div>

							<div class="text-center">
								<button type="submit" class="btn btn-success mt-4">{{ __('Ubah password') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	@include('layouts.footers.auth')
</div>
@endsection