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
                            <h3 class="mb-0">{{ __('Edit Lowongan Kerja') }}</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('job.index') }}" class="btn btn-sm btn-primary">{{ __('Kembali') }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('job.update', $job) }}" autocomplete="off" enctype="multipart/form-data">
                        @method('put')
                        @csrf

                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="input-company">{{ __('Nama Perusahaan') }}</label>
                                <input type="text" name="company" id="input-company" class="form-control{{ $errors->has('company') ? ' is-invalid' : '' }}" placeholder="{{ __('Nama Perusahaan') }}" value="{{ old('company', $job->company) }}" required>

                                @if ($errors->has('company'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('company') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="">Poster/Pamflet</label>
                                <img class="poster-preview w-100 mb-3 d-none" src="" alt="Poster / Pamflet" data-toggle="modal" data-target="#zoomImageModal" style="height: 256px; object-fit: contain">
                                <div class="row mx-0 mb-3" style="flex-wrap: nowrap;">
                                    <input id="poster" class="d-none" type="file" name="poster" accept="image/*">
                                    <input id="delete-poster" type="hidden" name="delete-poster" value="0">
                                    <button id="poster-add" type="button" class="btn btn-primary">Tambah Gambar</button>
                                    <button id="poster-remove" type="button" class="btn btn-danger d-none">Hapus Gambar</button>
                                </div>
                                @if ($errors->has('poster'))
                                <span class="invalid-feedback" role="alert" style="display: block;">
                                    <strong>{{ $errors->first('poster') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="form-control-label" for="input-description">{{ __('Deskripsi') }}</label>
                                <textarea name="description" id="input-description"
                                    class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    rows="4">{{ old('description', $job->description) }}</textarea>

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

                            <div class="form-group">
                                <label class="form-control-label" for="input-seen_until">Ditampilkan sampai</label>
                                <input type="text" name="seen_until" id="input-seen_until"
                                    class="form-control datepicker{{ $errors->has('seen_until') ? ' is-invalid' : '' }}"
                                    value="{{ old('seen_until', $job->seen_until) }}" required>

                                @if ($errors->has('seen_until'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('seen_until') }}</strong>
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
                                    placeholder="{{ __('Jalan (opsional)') }}" value="{{ old('street', $job->street) }}">
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
                                <p class="form-control-label" for="input-requirements">Persyaratan</p>
                                @php $requirements = old('requirements', json_decode($job->requirements)) @endphp
                                @if (empty($requirements))
                                <div class="row mx-0 mb-3" style="flex-wrap: nowrap;">
                                    <input type="text" name="requirements[]" class="input-requirements form-control" >
                                    <button type="button" class="btn-remove btn btn-danger ml-2"><i class="fa fa-minus"></i></button>
                                </div>
                                @else
                                @foreach ($requirements as $value)
                                <div class="row mx-0 mb-3" style="flex-wrap: nowrap;">
                                    <input type="text" name="requirements[]" class="input-requirements form-control" value="{{ $value }}" >
                                    <button type="button" class="btn-remove btn btn-danger ml-2"><i class="fa fa-minus"></i></button>
                                </div>
                                @endforeach
                                @endif
                                <button type="button" class="btn-add btn btn-success">{{ __('Tambah') }}</button>
                            </div>

                            <div class="form-check">
                                <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="1" name="published" id="publish" {{ $job->published == '1' ? 'checked' : '' }}>
                                    Terbitkan
                                </label>
                                </div>
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
    {{-- Form persyaratan --}}
    <div id="input-persyaratan" class="d-none">
        <div class="row mx-0 mb-3" style="flex-wrap: nowrap;">
            <input type="text" name="requirements[]" class="input-requirements form-control"  >
            <button type="button" class="btn-remove btn btn-danger ml-2"><i class="fa fa-minus"></i></button>
        </div>
    </div>

    {{-- Modal zoom image --}}
    <div class="modal fade" id="zoomImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img class="poster-preview w-100" src="" >
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.tiny.cloud/1/11gbqitr6wxn3kei2wjuino6e84fucjdwff4sjpt48ima2u0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    $(function() {
        function bindBtnRemove() {
            $('.btn-remove').click(function () { 
                $(this).parent().remove() 
                $('.btn-remove').unbind();
                bindBtnRemove();
            });
        }

        tinymce.init({
            selector: '#input-description',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify',
            menubar: false
        });

        $('.datepicker').datepicker();

        $('.btn-add').click(function() {
            $(this).before($('#input-persyaratan').html().trim())
            bindBtnRemove();
        })

        $('#poster-add').click(function () {
            $('#poster').click()
        })

        $('#poster-remove').click(function () {
            $('#poster').val("")
            $('.poster-preview, #poster-remove').addClass('d-none')
            $('#poster-add').text('Tambah Gambar')
            $('#delete-poster').val(1)
        })

        $('#poster').change(function (e) {
            const src = URL.createObjectURL(e.currentTarget.files[0])
            $('.poster-preview').attr('src', src)
            $('.poster-preview, #poster-remove').removeClass('d-none')
            $('#poster-add').text('Ganti Gambar')
            $('#delete-poster').val(0)
        })

        bindBtnRemove();

        @if (!empty($job->poster))
        $('.poster-preview').attr('src', '/storage/{{ $job->poster }}')
        $('.poster-preview, #poster-remove').removeClass('d-none')
        $('#poster-add').text('Ganti Gambar')
        @endif

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