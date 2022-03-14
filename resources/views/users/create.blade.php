@extends('layouts.app', ['title' => __('Tambah Alumni')])

@section('content')
@include('users.partials.header', ['title' => __('Tambah Alumni')])

<div class="container-fluid mt-3">
  <div class="row">
    <div class="col-xl-12 order-xl-1">
      <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
          <div class="row align-items-center">
            <div class="col-8">
              <h3 class="mb-0">{{ __('Informasi Alumni') }}</h3>
            </div>
            <div class="col-4 text-right">
              <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ route('user.store') }}" autocomplete="off">
            @csrf

            <div class="pl-lg-4">
              <div class="form-group">
                <label class="form-control-label" for="input-nisn">{{ __('NISN') }}</label>
                <input type="text" name="nisn" id="input-nisn"
                  class="form-control{{ $errors->has('nisn') ? ' is-invalid' : '' }}"
                  placeholder="{{ __('NISN') }}" value="{{ old('nisn') }}" required>
                @if ($errors->has('nisn'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('nisn') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-name">{{ __('Nama Lengkap') }}</label>
                <input type="text" name="name" id="input-name"
                  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                  placeholder="{{ __('Nama Lengkap') }}" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                <input type="email" name="email" id="input-email"
                  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                  placeholder="{{ __('Email (Optional)') }}" value="{{ old('email') }}">

                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-pob">{{ __('Tempat Lahir') }}</label>
                <input type="text" name="pob" id="input-pob"
                  class="form-control{{ $errors->has('pob') ? ' is-invalid' : '' }}"
                  placeholder="{{ __('Tempat Lahir (Optional)') }}" value="{{ old('pob') }}">

                @if ($errors->has('pob'))
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('pob') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-dob">{{ __('Tanggal Lahir') }}</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                  </div>
                  <input name="dob" id="input-dob" class="form-control datepicker{{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="Tanggal Lahir" type="text" value="{{ old('dob') }}" required>
                  @if ($errors->has('dob'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('dob') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label class="form-control-label" for="input-department">{{ __('Jurusan') }}</label>
                <select name="department_slug" id="input-department"
                  class="form-control {{ $errors->has('department_slug') ? ' is-invalid' : '' }}"
                  {{ empty(\App\Department::all()) ? 'disabled' : '' }}>
                  <option selected disabled>- Silahkan pilih -</option>
                  @foreach (\App\Department::all() as $department)
                  <option {{ old('department_slug') == $department->code ? 'selected' : '' }} value="{{ $department->code }}">
                    {{ $department->department }}</option>
                  @endforeach
                </select>

                @if ($errors->has('department_slug'))
                <span class="invalid-feedback" role="alert" style="display: block;">
                  <strong>{{ $errors->first('department_slug') }}</strong>
                </span>
                @endif
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-success mt-4">{{ __('Simpan') }}</button>
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

@push('js')
<script src="/argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush