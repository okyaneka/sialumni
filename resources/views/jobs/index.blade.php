@extends('layouts.app', ['title' => __('Lowongan Kerja')])

@section('content')
@include('users.partials.header', ['title' => __('Lowongan Kerja')])

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <form action="{{ route('job.index') }}" class="form-inline" method="GET">
                    <div class="input-group input-group-sm mb-2">
                        <input type="text" name="company" class="form-control" placeholder="Cari Perusahaan" aria-label="Cari Perusahaan" aria-describedby="search" value="{{ isset($_GET['company']) ? $_GET['company'] : ''  }}">
                        <div class="input-group-append">
                            <button class="btn" type="submit" id="search"><i class="fa fa-search"></i></button>
                        </div>
                    </div>

                    @if (empty(!$filter))
                    <span class="px-2 mx-1 badge badge-default text-white">
                        <a href="{{ url()->current() }}">Hapus filter pencarian</a>
                    </span> 
                    @endif
                </form>
            </div>

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="alert alert-primary alert-dismissible fade show">
                @if($jobs->total() == 0)
                {{ 'Tidak ada entri' }}
                @else
                {{ 'Menampilkan '.count($jobs).' dari '.$jobs->total() }}
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center float-right">
                        <div class="col-4 text-right">
                            <a href="{{ route('job.create') }}" class="btn btn-sm btn-primary">{{ __('Buat baru') }}</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nama Perusahaan</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telepon</th>
                                <th scope="col">Gaji</th>
                                <th scope="col">Sampai tanggal</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                            <tr>
                                <td><a href="{{ route('job.show', $job) }}">{{ $job->company }}</a></td>
                                <?php $location = unserialize($job->location);?>
                                <td>{{ $location['street'] }}, {{ \App\Location::getDistrict($location['district'])->nama }}, {{ \App\Location::getProvince($location['province'])->nama }}</td>
                                <td>{{ $job->email }}</td>
                                <td>{{ $job->phone }}</td>
                                <td>{{ 'Rp. '.number_format($job->salary, 2) }}</td>
                                <td>{{ $job->duedate }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <form action="{{ route('job.destroy', $job) }}" method="post">
                                                @csrf
                                                @method('delete')

                                                <a class="dropdown-item" href="{{ route('job.edit', $job) }}">{{ __('Edit') }}</a>
                                                <button type="button" class="dropdown-item" onclick="confirm('{{ __("Apakah anda yakin akan menghapus lowongan kerja ini?") }}') ? this.parentElement.submit() : ''">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $jobs->appends($_GET)->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
