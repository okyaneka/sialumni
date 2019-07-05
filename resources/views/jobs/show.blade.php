@extends('layouts.default', ['title' => __('Lowongan Kerja')])

@section('content')
@include('layouts.headers.header', ['title' => $job->company])

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <div class="card bg-white">
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
                        <strong>Alamat : {{ $location['street'] }}, {{ \App\Location::getVillage($location['address'])->nama }}, {{ \App\Location::getSubDistrict($location['sub_district'])->nama }}, {{ \App\Location::getDistrict($location['district'])->nama }}, {{ \App\Location::getProvince($location['province'])->nama }}</strong><br>
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

    {{-- @include('layouts.footers.auth') --}}
</div>
@endsection
