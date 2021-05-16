@extends('layouts.app', ['title' => __('Lowongan Kerja')])

@section('content')
@include('users.partials.header', ['title' => __('Edit Lowongan Kerja')])

<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">{{ __('Edit Jurusan') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('job.index') }}" class="btn btn-sm btn-primary">{{ __('Kembali') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('job.update', $job) }}" autocomplete="off">
                        @method('put')
                        @csrf

                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label"
                                    for="input-company">{{ __('Nama Perusahaan') }}</label>
                                <input type="text" name="company" id="input-company"
                                    class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Nama Perusahaan') }}" value="{{ old('company', $job->company) }}" required>

                                @if ($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-description">{{ __('Deskripsi') }}</label>
                                <textarea name="description" id="input-description"
                                    class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" rows="4"
                                    required>{{ old('description', $job->description) }}</textarea>

                                @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-position">Posisi</label>
                                <input type="text" name="position" id="input-position"
                                    class="form-control{{ $errors->has('position') ? ' is-invalid' : '' }}"
                                    placeholder="Posisi" value="{{ old('position', $job->position) }}" required>

                                @if ($errors->has('position'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('position') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-salary">Capaian gaji</label>
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="number" name="salary" id="input-salary"
                                        class="form-control{{ $errors->has('salary') ? ' is-invalid' : '' }}"
                                        value="{{ old('salary', $job->salary) }}" placeholder="(opsional)">
                                </div>

                                @if ($errors->has('salary'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('salary') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-duedate">Dibuka sampai</label>
                                <input type="text" name="duedate" id="input-duedate"
                                    class="form-control datepicker{{ $errors->has('duedate') ? ' is-invalid' : '' }}"
                                    value="{{ old('duedate', $job->duedate) }}" required>

                                @if ($errors->has('duedate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('duedate') }}</strong>
                                </span>
                                @endif
                            </div>
                            <hr>

                            <p class="text-muted">Alamat</p>
                            {{-- Provinsi --}}
                            <div class="form-group">
                                <label class="form-control-label" for="input-province">Provinsi</label>
                                <select type="text" name="province" id="input-province"
                                    class="form-control {{ $errors->has('province') ? ' is-invalid' : '' }}"
                                    placeholder="Provinsi">

                                </select>
                                @if ($errors->has('province'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('province') }}</strong>
                                </span>
                                @endif
                            </div>

                            {{-- Kabupaten --}}
                            <div class="form-group">
                                <label class="form-control-label" for="input-district">{{ __('Kabupaten') }}</label>
                                <select type="text" name="district" id="input-district"
                                    class="form-control {{ $errors->has('district') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Kabupaten') }}">
                                </select>
                                @if ($errors->has('district'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('district') }}</strong>
                                </span>
                                @endif
                            </div>

                            {{-- Alamat --}}
                            <div class="form-group">
                                <label class="form-control-label" for="input-street">{{ __('Jalan') }}</label>
                                <input type="text" name="street" id="input-street"
                                    class="form-control {{ $errors->has('street') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Jalan') }}" value="{{ old('street', $job->street) }}">
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

                            <div class="form-group">
                                <label class="form-control-label" for="input-email">Email</label>
                                <input type="text" name="email" id="input-email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="Email (opsional)" value="{{ old('email', $job->email) }}">

                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-phone">Nomor telepon</label>
                                <input type="text" name="phone" id="input-phone"
                                    class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                    placeholder="Nomor telepon (opsional)" value="{{ old('phone', $job->phone) }}">

                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                @php $requirements = old('requirements', unserialize($job->requirements)) @endphp
                                <label class="form-control-label" for="input-requirements">Persyaratan</label>
                                <input type="text" name="requirements[]" class="input-requirements form-control"
                                    required value="{{ is_array($requirements) ? $requirements[0] : '' }}">
                                @if (!empty(old('requirements', $requirements)))
                                @for ($i = 1; $i < count($requirements); $i++) @if (!empty($requirements[$i])) <input
                                    type="text" name="requirements[]" class="input-requirements form-control mt-3"
                                    value="{{ $requirements[$i] }}">
                                    @endif
                                    @endfor
                                    <input type="text" name="requirements[]"
                                        class="input-requirements form-control mt-3">
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
    </div>

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.tiny.cloud/1/11gbqitr6wxn3kei2wjuino6e84fucjdwff4sjpt48ima2u0/tinymce/5/tinymce.min.js"
    referrerpolicy="origin"></script>
<script type="text/javascript">
    $(function() {
        function inputRequrements() {    
            $('.input-requirements').last().keyup(function() {
                if ($(this).val() != '') {
                    $(this).after("<input type=''text' name='requirements[]' class='input-requirements form-control form-control-alternative mt-3'>");
                    $('.input-requirements').unbind();
                    inputRequrements();
                }
            });
        }

        tinymce.init({
            selector: '#input-description',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify',
            menubar: false
        });

        $('.datepicker').datepicker();

        inputRequrements();

        var prov_id = {{ old('province', $job->province_id) ?: 'false' }};
        var kab_id = {{ old('district', $job->district_id) ?: 'false' }};

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

        $('#input-province').change(function() {
            $('#input-district').empty();
            $('#input-district').append('<option value="">- Silahkan pilih -</option>');

            $.get('/api/kabupaten/'+$(this).val(), function(data, status) {
                $.each(data, function(i, val) {
                    $('#input-district').append('<option value="'+val.id+'">'+val.nama+'</option>');
                })
            });
        });
    });
</script>
@endpush
