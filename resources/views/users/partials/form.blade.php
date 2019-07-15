<form method="post" action="{{ $action }}" autocomplete="off">
    @csrf 
    @method($method)

    <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>

    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {!! session('status') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="pl-lg-4">
        {{-- Nama --}}
        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-name">{{ __('Nama') }}</label>
            <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}"
            placeholder="{{ __('Nama') }}" value="{{ old('name', $user->name) }}" required {{ $user->isDataComplete() ? 'disabled' : '' }}>                                
            @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('name') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Jenis Kelamin --}}
        <div class="form-group {{ $errors->has('gender') ? 'has-danger' : '' }}">
            <label for="input-gender" class="form-control-label">Jenis Kelamin</label>
            <select name="gender" id="input-gender" class="form-control form-control-alternative {{ $errors->has('gender') ? ' is-invalid' : '' }}" {{ $user->isDataComplete() ? 'disabled' : '' }}>
                <option {{ $user->gender == '' ? 'selected' : '' }} value=''>- Silahkan pilih -</option>
                <option {{ $user->gender == 'M' ? 'selected' : '' }} value='M'>Laki-laki</option>
                <option {{ $user->gender == 'F' ? 'selected' : '' }} value='F'>Perempuan</option>
            </select>

            @if ($errors->has('gender'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('gender') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Provinsi --}}
        <div class="form-group{{ $errors->has('province') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-province">Provinsi</label>
            <select type="text" name="province" id="input-province" class="form-control form-control-alternative {{ $errors->has('province') ? ' is-invalid' : '' }}" placeholder="Provinsi">

            </select>
            @if ($errors->has('province'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('province') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Kabupaten --}}
        <div class="form-group{{ $errors->has('district') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-district">{{ __('Kabupaten') }}</label>
            <select type="text" name="district" id="input-district" class="form-control form-control-alternative {{ $errors->has('district') ? ' is-invalid' : '' }}" placeholder="{{ __('Kabupaten') }}">
            </select>
            @if ($errors->has('district'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('district') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Kecamatan --}}
        <div class="form-group{{ $errors->has('sub_district') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-sub_district">{{ __('Kecamatan') }}</label>
            <select type="text" name="sub_district" id="input-sub_district" class="form-control form-control-alternative {{ $errors->has('sub_district') ? ' is-invalid' : '' }}" placeholder="{{ __('Kecamatan') }}">
            </select>
            @if ($errors->has('sub_district'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('sub_district') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Desa --}}
        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-address">{{ __('Desa') }}</label>
            <select type="text" name="address" id="input-address" class="form-control form-control-alternative {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="{{ __('Desa') }}">
            </select>
            <small class="form-text text-muted">
                Desa / Kelurahan
            </small>
            @if ($errors->has('address'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('address') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Alamat --}}
        <div class="form-group{{ $errors->has('street') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-street">{{ __('Alamat') }}</label>
            <input type="text" name="street" id="input-street" class="form-control form-control-alternative {{ $errors->has('street') ? ' is-invalid' : '' }}" placeholder="{{ __('Alamat') }}" value="{{ old('street',  $user->street) }}">
            <small class="form-text text-muted">
                Jalan / Dusun / RT / RW
            </small>
            @if ($errors->has('street'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('street') }}</strong>
            </span> 
            @endif
        </div>
        <hr>

        {{-- Tempat Lahir --}}
        <div class="form-group{{ $errors->has('pob') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-pob">{{ __('Tempat Lahir') }}</label>
            <input type="text" name="pob" id="input-pob" class="form-control form-control-alternative {{ $errors->has('pob') ? ' is-invalid' : '' }}" placeholder="{{ __('Tempat Lahir') }}" value="{{ old('pob', $user->pob) }}" {{ $user->isDataComplete() ? 'disabled' : '' }}>
            @if ($errors->has('pob'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('pob') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Tanggal Lahir --}}
        <div class="form-group{{ $errors->has('dob') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-dob">{{ __('Tanggal Lahir') }}</label>
            <input type="text" name="dob" id="input-dob" class="form-control form-control-alternative datepicker {{ $errors->has('dob') ? ' is-invalid' : '' }}" placeholder="{{ __('Tanggal Lahir') }}" value="{{ old('dob', date('m/d/Y', strtotime($user->dob))) }}" {{ $user->isDataComplete() ? 'disabled' : '' }}>
            @if ($errors->has('dob'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('dob') }}</strong>
            </span> 
            @endif
        </div>
        <hr>

        {{-- Jurusan --}}
        <div class="form-group{{ $errors->has('department') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-department">{{ __('Jurusan') }}</label>
            <select name="department" id="input-department" class="form-control form-control-alternative {{ $errors->has('department') ? ' is-invalid' : '' }}" {{ empty(\App\Department::all()) ? 'disabled' : '' }} {{ $user->isDataComplete() ? 'disabled' : '' }}>
                <option {{ $user->department == '' ? 'selected' : '' }} value=''>- Silahkan pilih -</option>
                @foreach (\App\Department::all() as $department)
                <option {{ $user->department == $department->code ? 'selected' : '' }} value="{{ $department->code }}">{{ $department->department }}</option>
                @endforeach
            </select>

            @if ($errors->has('department'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('department') }}</strong>
            </span> 
            @endif
        </div>

        {{-- Tahun Lulus --}}
        <div class="form-group{{ $errors->has('grad') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-grad">{{ __('Tahun Lulus') }}</label>
            <input type="text" name="grad" id="input-grad" class="form-control form-control-alternative {{ $errors->has('grad') ? ' is-invalid' : '' }}" placeholder="{{ __('Tahun Lulus') }}" value="{{ old('grad', $user->grad) }}" {{ $user->isDataComplete() ? 'disabled' : '' }}>

            @if ($errors->has('grad'))
            <span class="invalid-feedback" role="alert" style="display: block;">
                <strong>{{ $errors->first('grad') }}</strong>
            </span> 
            @endif
        </div>
        <hr>

        {{-- Status --}}
        @if (count($user->statuses()->get()) == 0)
        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
            <label class="form-control-label">{{ __('Status') }}</label>
            <select name="status[n][status_id]" class="input-status form-control form-control-alternative {{ $errors->has('status') ? ' is-invalid' : '' }}" {{ empty(\App\Status::all()) ? 'disabled' : '' }}>
                <option {{ $user->status == '' ? 'selected' : '' }} value=''>- Silahkan pilih -</option>
                @foreach (\App\Status::all() as $status)
                <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        @endif

        @foreach ($user->statuses()->get() as $s)
        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
            <input type="hidden" name="status[{{ $s->id }}][id]" value="{{ $s->id }}">
            <label class="form-control-label">{{ __('Status') }}</label>
            <select name="status[{{ $s->id }}][status_id]" class="input-status form-control form-control-alternative {{ $errors->has('status') ? ' is-invalid' : '' }}" {{ empty(\App\Status::all()) ? 'disabled' : '' }}>
                <option value=''>- Silahkan pilih -</option>
                @foreach (\App\Status::all() as $status)
                <option {{ $s->pivot->status_id == $status->id ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>

            <div class="form-row mt-3">
                <div class="col-8">
                    <input type="text" title="Keterangan (opsional)" name="status[{{ $s->id }}][info]" id="input-phone" class="form-control form-control-alternative {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Keterangan (opsional)') }}" value="{{ old('info', $s->pivot->info) }}">
                    <small class="form-text text-muted">
                        Keterangan (opsional)
                    </small>
                </div>
                <div class="col-4">
                    <input type="text" title="Tahun (opsional)" name="status[{{ $s->id }}][year]" id="input-phone" class="form-control form-control-alternative {{ $errors->has('year') ? ' is-invalid' : '' }}" placeholder="{{ __('Tahun (opsional)') }}" value="{{ old('year', $s->pivot->year) }}" required>
                    <small class="form-text text-muted">
                        Sampai Tahun? (opsional)
                    </small>
                </div>
            </div>
        </div>

        @if ($s->id == 1 && count($user->statuses()->get()) < 2)
        <div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">
            <label class="form-control-label">{{ __('Status 2') }}</label>
            <select name="status[n][status_id]" class="input-status form-control form-control-alternative {{ $errors->has('status') ? ' is-invalid' : '' }}" {{ empty(\App\Status::all()) ? 'disabled' : '' }}>
                <option {{ $user->status == '' ? 'selected' : '' }} value=''>- Silahkan pilih -</option>
                @foreach (\App\Status::all() as $status)
                <option value="{{ $status->id }}">{{ $status->status }}</option>
                @endforeach
            </select>
        </div>
        @endif
        @endforeach
        <hr>


        {{-- Telepon --}}
        <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
            <label class="form-control-label" for="input-phone">{{ __('Nomor Handphone') }}</label>
            <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative {{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Nomor Handphone') }}" value="{{ old('phone', $user->phone) }}">
            @if ($errors->has('phone'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('phone') }}</strong>
            </span> 
            @endif
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
        </div>
    </div>
</form>

@push('js')
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('.datepicker').datepicker();

        function refresh(input, index) {
            if ($(input).nextAll().length == 0) {
                $(input).after('<div class="form-row mt-3">'+
                    '<div class="col-8">'+
                    '<input type="text" title="Keterangan (opsional)" name="status['+index+'][info]" id="input-phone" placeholder="Keterangan (opsional)" class="form-control form-control-alternative ">'+
                    '<small class="form-text text-muted">Keterangan (opsional)</small>'+
                    '</div>'+
                    '<div class="col-4">'+
                    '<input type="text" title="Tahun (opsional)" name="status['+index+'][year]" id="input-phone" placeholder="Tahun (opsional)" class="form-control form-control-alternative ">'+
                    '<small class="form-text text-muted">Sampai Tahun? (opsional)</small></div></div>');
            } 

            if ($(input).val() == '') {
                $(input).next().remove();
            }
        }

        $('.input-status').change(function () {
            refresh($(this), 'n');
        });

        $($('.input-status')[0]).change(function () {
            if ($('.input-status').length < 2 && $(this).val() == 1) {
                $(this).parent().after('<div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }}">'+
                    '<label class="form-control-label">{{ __('Status 2') }}</label>'+
                    '<select name="status[m][status_id]" class="input-status form-control form-control-alternative {{ $errors->has('status') ? ' is-invalid' : '' }}" {{ empty(\App\Status::all()) ? 'disabled' : '' }}>'+
                    '<option {{ $user->status == '' ? 'selected' : '' }} value="">- Silahkan pilih -</option>'+
                    @foreach (\App\Status::all() as $status)
                    '<option value="{{ $status->id }}">{{ $status->status }}</option>'+
                    @endforeach
                    '</select></div>');

                $('.input-status').change(function () {
                    refresh($(this), 'm');
                });
            } else {
                $($('.input-status')[1]).parent().remove();
            }
        });

        var prov_id = {{ old('province', $user->province) ?: 'false' }};
        var kab_id = {{ old('district', $user->district) ?: 'false' }};
        var kec_id = {{ old('sub_district', $user->sub_district) ?: 'false' }};
        var kel_id = {{ old('address', $user->address) ?: 'false' }};

        $.get('/api/provinsi', function(data, status) {
            selected = '';
            $('#input-province').append('<option value="">- Silahkan pilih -</option>');
            $.each(data, function( i, val ) {
                if (prov_id == val.id) {
                    selected = 'selected';
                } else {
                    selected = '';
                }

                if (val.id == false) {
                    $('#input-province').append('<option value="'+prov_id+'" selected>'+prov_id+'</option>');
                } else {
                    $('#input-province').append('<option value="'+val.id+'" '+selected+'>'+val.nama+'</option>');
                }
            });
        });

        if (prov_id != false) {
            $.get('/api/kabupaten/'+prov_id, function(data, status) {
                $('#input-district').append('<option value="">- Silahkan pilih -</option>');
                $.each(data, function(i, val) {
                    if (kab_id == val.id) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }

                    if (val.id == null) {
                        $('#input-district').append('<option value="'+kab_id+'" selected>'+kab_id+'</option>');
                    } else {
                        $('#input-district').append('<option value="'+val.id+'" '+selected+'>'+val.nama+'</option>');
                    }
                })
            });
        }

        if (kec_id != false) {
            $.get('/api/kecamatan/'+kab_id, function(data, status) {
                $('#input-sub_district').append('<option value="">- Silahkan pilih -</option>');
                $.each(data, function(i, val) {
                    if (kec_id == val.id) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }

                    if (val.id == null) {
                        $('#input-sub_district').append('<option value="'+kec_id+'" selected>'+kec_id+'</option>');
                    } else {
                        $('#input-sub_district').append('<option value="'+val.id+'" '+selected+'>'+val.nama+'</option>');
                    }
                })
            });
        }

        if (kel_id != false) {
            $.get('/api/desa/'+kec_id, function(data, status) {
                $('#input-address').append('<option value="">- Silahkan pilih -</option>');
                $.each(data, function(i, val) {
                    if (kel_id == val.id) {
                        selected = 'selected';
                    } else {
                        selected = '';
                    }

                    if (val.id == null) {
                        $('#input-address').append('<option value="'+kel_id+'" selected>'+kel_id+'</option>');
                    } else {
                        $('#input-address').append('<option value="'+val.id+'" '+selected+'>'+val.nama+'</option>');
                    }
                    
                })
            });
        }

        $('#input-province').click(function() {
            $('#input-district').empty();
            $('#input-sub_district').empty();
            $('#input-address').empty();
            $('#input-district').append('<option value="">- Silahkan pilih -</option>');

            $.get('/api/kabupaten/'+$(this).val(), function(data, status) {
                $.each(data, function(i, val) {
                    $('#input-district').append('<option value="'+val.id+'">'+val.nama+'</option>');
                })
            });
        });

        $('#input-district').click(function() {
            $('#input-sub_district').empty();
            $('#input-address').empty();
            $('#input-sub_district').append('<option value="">- Silahkan pilih -</option>');

            $.get('/api/kecamatan/'+$(this).val(), function(data, status) {
                $.each(data, function(i, val) {
                    $('#input-sub_district').append('<option value="'+val.id+'">'+val.nama+'</option>');
                })
            });
        });

        $('#input-sub_district').click(function() {
            $('#input-address').empty();
            $('#input-address').append('<option value="">- Silahkan pilih -</option>');

            $.get('/api/desa/'+$(this).val(), function(data, status) {
                $.each(data, function(i, val) {
                    $('#input-address').append('<option value="'+val.id+'">'+val.nama+'</option>');
                });
            });
        });
    });
</script>
@endpush