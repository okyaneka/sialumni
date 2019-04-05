@extends('layouts.app', ['title' => __('Jurusan')])

@section('content')
    @include('users.partials.header', ['title' => __('Tambah Jurusan')])

    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-center">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Tambah Jurusan') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('department.index') }}" class="btn btn-sm btn-primary">{{ __('Kembali') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('department.store') }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-code">{{ __('Kode Jurusan') }}</label>
                                    <input type="text" name="code" id="input-code" class="form-control form-control-alternative{{ $errors->has('code') ? ' is-invalid' : '' }}" placeholder="{{ __('Kode Jurusan') }}" value="{{ old('code') }}" required>

                                    @if ($errors->has('code'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('department') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-department">{{ __('Jurusan') }}</label>
                                    <input type="text" name="department" id="input-department" class="form-control form-control-alternative{{ $errors->has('department') ? ' is-invalid' : '' }}" placeholder="{{ __('Jurusan') }}" value="{{ old('department') }}" required>

                                    @if ($errors->has('department'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('department') }}</strong>
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
