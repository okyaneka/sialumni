@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
@include('users.partials.header', [
    'title' => __('Profil') . ' '. $user->name,
    'class' => 'mb-lg-7',
    ])

<div class="container-fluid mt--5">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 mb-5 mb-xl-0 mt-xl--5 ">
            @include('cards.user', ['user' => $user])
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection