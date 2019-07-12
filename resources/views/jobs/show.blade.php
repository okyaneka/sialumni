@extends('layouts.default', ['title' => __('Lowongan Kerja')])

@section('content')
@include('layouts.headers.header', ['title' => $job->company])

<div class="container mt-3">
    @include('layouts.navbars.breadcrumb', ['job' => $job->company])
    <div class="row">
        <div class="col">
            <div class="card bg-white mb-7">
                <div class="card-body">
                    <h2 class="display-2 text-primary">{{ $job->company }}</h2>
                    <h4 class="text-muted">{{ date('d/m/Y', strtotime($job->updated_at)) }}</h4>
                    <hr>
                    @foreach (explode("\n", $job->description) as $description)
                    <p>{{ $description }}</p>
                    @endforeach
                    <div class="bg-success p-3 text-white m-5 ml-0">
                        <strong>Posisi yang dibutuhkan : {{ $job->position }}</strong><br>
                        <strong>Gaji mencapai : Rp. {{ number_format($job->salary) }}</strong><br>
                        <?php $location = unserialize($job->location);?>
                        <strong>Alamat : {{ $location['street'] }}, {{ \App\Location::getDistrict($location['district'])->nama }}, {{ \App\Location::getProvince($location['province'])->nama }}</strong><br>
                        <strong>Nomor telepon : {{ $job->phone }}</strong><br>
                        <strong>Email : {{ $job->email }}</strong>
                    </div>
                    <p>Syarat yang diperlukan :</p>
                    <ul>
                        @foreach (unserialize($job->requirements) as $requirements)
                        <li>{{ $requirements }}</li>
                        @endforeach
                    </ul>
                    <p>Kirim lamaran anda sebelum tanggal <span class="text-primary">{{ date('d/m/Y', strtotime($job->duedate)) }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</div>
@endsection
