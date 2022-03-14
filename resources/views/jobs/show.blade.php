@extends('layouts.default', ['title' => __('Lowongan Kerja')])

@section('content')
@include('layouts.headers.header', ['title' => $job->company])

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="card bg-white mb-7">
                <div class="card-body">
                    <small class="text-muted">{{ date('d/m/Y', strtotime($job->updated_at)) }}</small>
                    <h2 class="display-2 text-primary">{{ $job->company }}</h2>
                    @if (!empty($job->poster))
                    <hr>
                    <div class="text-center">
                        <img class="w-75" src="/storage/{{ $job->poster }}" alt="">
                    </div>
                    @endif
                    <hr>
                    {!! $job->description !!}
                    <div class="bg-success p-3 text-white my-5 ml-0">
                        <strong>Posisi yang dibutuhkan : {{ $job->position }}</strong><br>
                        <strong>Gaji mencapai : Rp. {{ number_format($job->salary) }}</strong><br>
                        <strong>Alamat : {{ $job->full_address }}</strong><br>
                        <strong>Nomor telepon : {{ $job->phone }}</strong><br>
                        <strong>Email : {{ $job->email }}</strong>
                    </div>
                    @if (!empty($job->requirements) && !empty(json_decode($job->requirements)))
                    <p>Syarat yang diperlukan :</p>
                    <ul>
                        @foreach (json_decode($job->requirements) as $requirements)
                        <li>{{ $requirements }}</li>
                        @endforeach
                    </ul>
                    @endif
                    <p>Dibuka sampai <span class="text-primary">{{ date('d/m/Y', strtotime($job->duedate)) }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
            xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</div>
@endsection