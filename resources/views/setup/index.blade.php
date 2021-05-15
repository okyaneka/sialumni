@extends('layouts.setup', ['class' => 'bg-default'])

@section('content')
<div class="container-fluid">
  <div class="container mt--7 pb-5">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">
        <div class="card shadow border-0">
          <div class="card-body px-lg-5 py-lg-5">
            <form action="{{ route('setup.store') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="text-center mb-4">
                <span>Installasi</span>
              </div>

              <div class="alert alert-secondary">
                <span>Requirements:</span>
                <ul class="mb-0 pl-4">
                  <li>
                    <span>php ^7.2.5|^8.0</span>
                    @if ($status['php'])
                    <span class="float-right text-success fa fa-check-circle"></span>
                    @else
                    <span class="float-right text-danger fa fa-times-circle-"></span>
                    @endif
                  </li>
                  <li>
                    <span>database</span>
                    @if ($status['db'])
                    <span class="float-right text-success fa fa-check-circle"></span>
                    @else
                    <span class="float-right text-danger fa fa-times-circle"></span>
                    @endif
                  </li>
                </ul>
              </div>

              <p class="small">Setup admin</p>

              <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
                <div class="input-group input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                  </div>
                  <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
                    placeholder="{{ __('Username') }}" type="text" name="username" value="{{ old('username') }}"
                    required autofocus>
                </div>
                @if ($errors->has('username'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('username') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                <div class="input-group input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                  </div>
                  <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    placeholder="{{ __('email') }}" type="email" name="email" value="{{ old('email') }}"
                    required>
                </div>
                @if ($errors->has('email'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                <div class="input-group input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
                  <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    placeholder="{{ __('Password') }}" type="password" name="password" required>
                </div>
                @if ($errors->has('password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>

              <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                <div class="input-group input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
                  <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    placeholder="{{ __('Confirm password') }}" type="password" name="password_confirmation" required>
                </div>
              </div>

              <p class="small text-justify">Sistem ini menggunakan fitur asisten virtual berupa chatbot yang ada di
                telegram, sehubungan itu maka diperlukan website dengan protokol https dan mengupload file
                certificate/public key dari https tersebut.</p>
              <div class="form-group mb-3">
                <input type="file" name="file" id="file" lang="en">
                @if ($errors->has('file'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('file') }}</strong>
                </span>
                @endif
              </div>

              <button class="btn btn-primary" type="submit">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection