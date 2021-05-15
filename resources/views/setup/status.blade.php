@extends('layouts.setup', ['class' => 'bg-default'])

@section('content')
<div class="container-fluid">
  <div class="container mt--7 pb-5">

    <div class="row justify-content-center">
      <div class="col">
        <div class="card">
          <div class="card-body">
            <p class="text-justify">Selamat! {{ env('APP_NAME') }} berhasil diinstall. Silahkan klik tombol berikut untuk memulai menggunakan aplikasi {{ config('app.name') }}.</p>
            <p class="text-center"><a class="btn btn-primary" href="{{ route('login') }}">Login untuk memulai menggunakan aplikasi</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection