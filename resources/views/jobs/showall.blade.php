@extends('layouts.default', ['title' => __('Lowongan Kerja')])

@section('content')
@include('layouts.headers.header', ['title' => 'Lowongan Kerja'])

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col mb-5">
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
                            <span class="text-muted small">{{ $j->full_address }}</span>
                        </div>
                        <div class="card-footer bg-primary py-2">
                            <h3><a href="{{ route('job.show', $j) }}" class="text-white">lihat detail</a></h3>
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
</div>
<div class="separator separator-bottom separator-skew zindex-100">
    <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
    </svg>
</div>
@endsection
