@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
@include('users.partials.header', [
    'title' => __('Halo') . ' '. auth()->user()->name,
    'description' => __('Halaman profil Sistem Informasi Alumni SMK Negeri Pringsurat'),
    'class' => 'col-lg-7',
])

<div class="container-fluid mt--5">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mt-xl--9 mt-lg-3 mt-md-7">
            @include('users.partials.cards')
        </div>
        <div class="col-xl-8 order-xl-1 mb-5">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="align-items-center">
                        <h3 class="mb-0">{{ __('Edit Profil') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    @include('users.partials.form', ['action' => route('profile.update'), 'method' => 'put', 'user' =>
                    auth()->user()])
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection