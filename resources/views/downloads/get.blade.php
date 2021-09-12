@extends('layouts.app', ['title' => __('Download Data')])

@section('content')
@include('users.partials.header', ['title' => __('Download Data Alumni')])

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 order-xl-1">
            <div class="card bg-white shadow">
                <div class="card-body">
                    <form action="{{ route('download.download') }}" method="POST">
                        @csrf @method('put')
                        <button type="submit" class="btn btn-primary">Download Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
