@extends('layouts.app')
@section('content')
@include('users.partials.header', [
'title' => __('Halo') . ' '. auth()->user()->name,
'description' => __('Selamat Datang di Sistem Informasi Alumni SMK Negeri Pringsurat'),
'class' => 'col-lg-7' ])

<div class="container-fluid mt-xl--9 mt--7">
    <div class="row">
        <div class="col-xl-8 mb-3">
            @if( !auth()->user()->isDataComplete() && !auth()->user()->isAdmin() )
            @include('users.partials.complete')
            @else
            @include('layouts.headers.cards')
            @endif
        </div>
        <div class="col-xl-4 mb-3 mb-xl-0">
            @include('users.partials.cards')
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush