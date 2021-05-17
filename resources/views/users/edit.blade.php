@extends('layouts.app', ['title' => __('Edit Data Siswa')])

@section('content')
@include('users.partials.header', ['title' => __('Edit Data Siswa')])

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-xl-8 offset-xl-2 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Data Siswa') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('users.partials.form', ['action' => route('user.update', $user), 'method' => 'put'])
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
