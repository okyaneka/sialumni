@extends('layouts.app', ['title' => __('User Management')])

@section('content')
@include('users.partials.header', ['title' => __('Batch Alumni')])

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 order-xl-1">
            @if (session('status'))
            <div class="alert alert-{{ session('status')['status'] }} alert-dismissible fade show mt-3" role="alert">
                <span>
                    {{ session('status')['message'] }}
                </span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Batch Alumni') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.insert_batch') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('put')

                        <div class="form-group">
                            <input type="file" class="form-control-file form-group{{ $errors->has('file') ? ' has-danger' : '' }}" name="file" id="file" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">Silahkan upload file .xlsx. Klik <a href="{{ route('larecipe.index') }}" target="_blank">Bantuan</a> untuk mendapatkan petunjuk lebih lanjut.</small>
                        </div>

                        @if ($errors->has('file'))
                        <div class="mb-3">
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span> 
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth')
</div>
@endsection
