@extends('layouts.default', ['title' => __('Lowongan Kerja')])

@section('content')
@include('layouts.headers.header', ['title' => 'Lowongan Kerja'])

<div class="container mt-5">
    <div class="row">
        <div class="col">
            <div class="col mb-3">
                <form action="{{ route('job.showall') }}" class="form-inline" method="GET">
                    <div class="input-group input-group-sm mb-2 ml-auto">
                        <input type="text" name="company" class="form-control" placeholder="Cari Perusahaan" aria-label="Cari Perusahaan" aria-describedby="search" value="{{ isset($_GET['company']) ? $_GET['company'] : ''  }}">
                        <div class="input-group-append">
                            <button class="btn" type="submit" id="search"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    &nbsp;
                    @if (empty(!$filter))
                    <span class="px-2 mx-1 badge badge-default text-white">
                        <a href="{{ url()->current() }}">Hapus semua filter</a>
                    </span> 
                    @endif
                </form>
            </div>

            <div class="alert alert-primary alert-dismissible fade show mb-3">
                @if($jobs->total() == 0)
                {{ 'Tidak ada entri' }}
                @else
                {{ 'Menampilkan '.count($jobs).' dari '.$jobs->total() }}
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row">
                @foreach ($jobs as $j)
                <div class="col-md-4 mb-3">
                    <div class="card bg-white">
                        <div class="card-body">
                            <h4>{{ $j->position }}</h4>
                            <h3 class="text-primary">{{ $j->company }}</h3>
                            <?php $location = unserialize($j->location);?>
                            <span class="text-muted small">{{ $location['street'] }}, {{ \App\Location::getVillage($location['address'])->nama }}, {{ \App\Location::getSubDistrict($location['sub_district'])->nama }}, {{ \App\Location::getDistrict($location['district'])->nama }}, {{ \App\Location::getProvince($location['province'])->nama }}</span>
                        </div>
                        <div class="card-footer bg-primary py-2">
                            <h3><a href="{{ route('job.show', $j) }}" class="text-white" target="_blank">lihat detail</a></h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    {{ $jobs->appends($_GET)->links() }}
                </nav>
            </div>
        </div>
    </div>

    {{-- @include('layouts.footers.auth') --}}
</div>
@endsection
