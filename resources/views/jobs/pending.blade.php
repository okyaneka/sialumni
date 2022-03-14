@extends('layouts.app', ['title' => __('Lowongan Kerja')])

@section('content')
@include('users.partials.header', ['title' => __('Lowongan Kerja')])

<div class="container-fluid mt-3">
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <a href="{{ route('job.create') }}" class="btn btn-sm btn-primary">{{ __('Tambah data') }}</a>
      </div>

      <div class="mb-3">
        <form action="{{ route('job.index') }}" class="form-inline" method="GET">
          <div class="input-group input-group-sm mb-2">
            <input type="text" name="company" class="form-control" placeholder="Cari Perusahaan"
              aria-label="Cari Perusahaan" aria-describedby="search"
              value="{{ isset($_GET['company']) ? $_GET['company'] : ''  }}">
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
      @if($jobs->total() == 0)
      <div class="alert alert-primary alert-dismissible fade show">
        {{ 'Tidak ada entri' }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @else
      <div class="alert alert-primary alert-dismissible fade show">
        {{ 'Menampilkan '.count($jobs).' dari '.$jobs->total() }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="card shadow">
        <div class="table-responsive">
          <table class="table table-hover table-striped align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Poster</th>
                <th scope="col" style="max-width: 100rem">Data mentah</th>
                <th scope="col">Tanggal dibuat</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($jobs as $job)
              <tr>
                <td><img height="64px" src="/storage/{{ $job->poster }}" alt=""></td>
                <td>
                  <div class="mb-1">{{ substr($job->raw_data, 0, 100) }}...</div>
                  <div><a href="{{ route('job.review', $job) }}">Review</a></div>
                </td>
                <td>
                  <div>{{ date('d-m-Y', strtotime($job->created_at)) }}</div>
                </td>
                <td class="text-right">
                  <div class="dropdown">
                    <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                      <form action="{{ route('job.destroy', $job) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="button" class="dropdown-item"
                          onclick="confirm('Apakah anda yakin akan menghapus lowongan kerja ini?') ? this.parentElement.submit() : ''">
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
        <div class=" card-footer py-4">
          <nav class="d-flex justify-content-end" aria-label="...">
            {{ $jobs->appends($_GET)->links() }}
          </nav>
        </div>
      </div>
      @endif
    </div>
  </div>

  @include('layouts.footers.auth')
</div>
@endsection