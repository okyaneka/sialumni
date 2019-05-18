@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
    @include('users.partials.header', [
        'title' => __('Halo') . ' '. auth()->user()->name,
        'description' => __('Halaman profil Sistem Informasi Alumni SMK Negeri Pringsurat'),
        'class' => 'col-lg-7',
    ])

<div class="container-fluid mt--5">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 mb-5 mb-xl-0 mt-xl--7 ">
            @include('cards.user', ['user' => auth()->user()])
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
