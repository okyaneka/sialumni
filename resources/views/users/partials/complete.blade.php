<div class="header pt-5 pt-md-8">
    <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
            <div class="align-items-center">
                <h3 class="mb-0 text-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {{ __('Lengkapi Data Berikut') }}</h3>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('home.update') }}" autocomplete="off">
                @csrf 

                <h6 class="heading-small text-muted mb-4">{{ __('TInggal selangkah lagi! Silahkan lengkapi data ini terlebih dahulu') }}</h6>
                

                <div class="pl-lg-4">
                    <div class="form-group{{ $errors->has('street') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-street">{{ __('Alamat') }}</label>
                        <input type="text" name="street" id="input-street" class="form-control form-control-alternative {{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Alamat') }}" value="{{ old('street') }}" required>
                        <small class="form-text text-muted">
                          Jalan / Dusun / RT / RW
                        </small>
                        @if ($errors->has('street'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('street') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-address">{{ __('Desa') }}</label>
                        <input type="text" name="address" id="input-address" class="form-control form-control-alternative {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Desa') }}" value="{{ old('address') }}" required>
                        <small class="form-text text-muted">
                          Desa / Kelurahan
                        </small>
                        @if ($errors->has('address'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('sub_district') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-sub_district">{{ __('Kecamatan') }}</label>
                        <input type="text" name="sub_district" id="input-sub_district" class="form-control form-control-alternative {{ $errors->has('sub_district') ? ' is-invalid' : '' }}" placeholder="{{ __('Kecamatan') }}" value="{{ old('sub_district') }}" required>
                        @if ($errors->has('sub_district'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('sub_district') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('district') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-district">{{ __('Kabupaten') }}</label>
                        <input type="text" name="district" id="input-district" class="form-control form-control-alternative {{ $errors->has('district') ? ' is-invalid' : '' }}" placeholder="{{ __('Kabupaten') }}" value="{{ old('district') }}" required>
                        @if ($errors->has('district'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('district') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <hr>
                    <div class="form-group{{ $errors->has('pob') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-pob">{{ __('Tempat Lahir') }}</label>
                        <input type="text" name="pob" id="input-pob" class="form-control form-control-alternative {{ $errors->has('pob') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempat Lahir') }}" value="{{ old('pob') }}" required>
                        @if ($errors->has('pob'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('pob') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-dob">{{ __('Tanggal Lahir') }}</label>
                        <input type="date" name="dob" id="input-dob" class="form-control form-control-alternative {{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="{{ __('Tanggal Lahir') }}" value="{{ old('dob') }}" required>
                        @if ($errors->has('dob'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('dob') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <hr>
                    <div class="form-group{{ $errors->has('department') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-department">{{ __('Jurusan') }}</label>
                        <select name="department" id="input-department" class="form-control form-control-alternative {{ $errors->has('department') ? ' is-invalid' : '' }}" {{ empty($departments) ? 'disabled' : '' }}>
                            @foreach ($departments as $department)
                                <option value="{{ $department->code }}">{{ $department->department }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('department'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('department') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('grad') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-grad">{{ __('Tahun Lulus') }}</label>
                        <input type="text" name="grad" id="input-grad" class="form-control form-control-alternative {{ $errors->has('grad') ? ' is-invalid' : '' }}" placeholder="{{ __('Tahun Lulus') }}" value="{{ old('grad') }}" required>

                        @if ($errors->has('grad'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('grad') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-status">{{ __('Status') }}</label>
                        <select name="status" id="input-status" class="form-control form-control-alternative {{ $errors->has('status') ? ' is-invalid' : '' }}" {{ empty($statuses) ? 'disabled' : '' }}>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->code }}">{{ $status->status }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('status'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <hr>
                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-phone">{{ __('Nomor Handphone') }}</label>
                        <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Nomor Handphone') }}" value="{{ old('phone') }}" required>
                        @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('telegram') ? ' has-danger' : '' }}">
                        <label class="form-control-label" for="input-telegram">{{ __('Nomor Telegram') }}</label>
                        <input type="text" name="telegram" id="input-telegram" class="form-control form-control-alternative {{ $errors->has('telegram') ? ' is-invalid' : '' }}" placeholder="{{ __('Nomor Telegram') }}" value="{{ old('telegram') }}" required>
                        @if ($errors->has('telegram'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('telegram') }}</strong>
                        </span> 
                        @endif
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success mt-4">{{ __('Simpan') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
