@extends('layouts.app', ['title' => __('Grup Alumni')])

@section('content')
    @include('users.partials.header', ['title' => __('Tambah Grup alumni')])

    <div class="container-fluid mt-5">
        <div class="d-flex justify-content-center">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Tambah Grup alumni') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('group.index') }}" class="btn btn-sm btn-primary">{{ __('Kembali') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('group.store') }}" autocomplete="off">
                            @csrf

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('grad') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-grad">{{ __('Tahun Lulus') }}</label>
                                    <input type="text" name="grad" id="input-grad" class="form-control form-control-alternative{{ $errors->has('grad') ? ' is-invalid' : '' }}" placeholder="{{ __('Tahun Lulus') }}" value="{{ old('grad') }}" required>

                                    @if ($errors->has('grad'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('grad') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('link') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-link">{{ __('Tautan Group') }}</label>
                                    <input type="text" name="link" id="input-link" class="form-control form-control-alternative{{ $errors->has('link') ? ' is-invalid' : '' }}" placeholder="{{ __('Tautan Group') }}" value="{{ old('link') }}" required>

                                    @if ($errors->has('link'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('link') }}</strong>
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
