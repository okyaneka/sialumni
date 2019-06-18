@extends('layouts.app', ['title' => __('Daftar alumni')])

@section('content')
{{-- @include('layouts.headers.cards') --}}
@include('users.partials.header', ['title' => __('Daftar alumni')])

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <form action="{{ route('user.index') }}" class="form-inline" method="GET">
                    <div class="input-group input-group-sm mb-2">
                        <input type="text" name="nama" class="form-control" placeholder="Cari Nama" aria-label="Cari Nama" aria-describedby="search" value="{{ isset($_GET['nama']) ? $_GET['nama'] : ''  }}">
                        <div class="input-group-append">
                            <button class="btn" type="submit" id="search"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    <span class="px-2">&nbsp;</span>
                    <a class="mb-2 mr-sm-2" href="#advancedSearch" data-toggle="modal">Pencarian lanjutan</a>
                    @foreach ($_GET as $key => $value)
                    @if (!empty($value) && $key != 'submit' && $key != 'page')
                    <?php $link = str_replace($key.'='.$value, '', url()->full());
                    $link = str_replace('&&', '&', $link);
                    $link = str_replace('?&', '?', $link);
                    $value = $key == 'status' ? \App\Status::find($value)->status : $value;
                    $value = $key == 'gender' ? $value == 'M' ? 'Laki-laki' : 'Perempuan' : $value;
                    ?>
                    <span class="px-2 mx-1 badge badge-default text-white">{{ $key }} : "{{ $value }}" | 
                        <a href="{{ $link }}">&times;</a>
                    </span> 
                    @endif
                    @endforeach

                    @if (empty(!$filter))
                    <span class="px-2 mx-1 badge badge-default text-white">
                        <a href="{{ url()->current() }}">Hapus semua filter</a>
                    </span> 
                    @endif
                </form>

                <div class="modal fade" id="advancedSearch" tabindex="-1" role="dialog" aria-labelledby="advancedSearch" aria-hidden="true">
                    <form action="{{ route('user.index') }}" method="GET">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Pencarian lanjutan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="px-3">

                                        <div class="form-group">
                                            <label class="form-control-label" for="nama">Nama</label>
                                            <input type="text" name="nama" id="input-code" class="form-control form-control-alternative" placeholder="Nama" value="{{ isset($_GET['nama']) ? $_GET['nama'] : ''  }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="jurusan" class="form-control-label">Jurusan</label>
                                            <select name="jurusan" id="jurusan" class="form-control form-control-alternative">
                                                <option value="">Semua Jurusan</option>
                                                @foreach (\App\Department::all() as $department)
                                                <option {{ isset($_GET['jurusan']) && ($_GET['jurusan'] == $department->code) ? 'selected' : '' }} value="{{ $department->code }}">{{ $department->department }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="status" class="form-control-label">Status lulusan</label>
                                            <select name="status" id="status" class="form-control form-control-alternative">
                                                <option value="">Semua Status</option>
                                                @foreach (\App\Status::all() as $status)
                                                <option {{ isset($_GET['status']) && ($_GET['status'] == $status->id) ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->status }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="tahun" class="form-control-label">Tahun lulus</label>
                                            <select name="tahun" id="tahun" class="form-control form-control-alternative">
                                                <option value="">Semua Tahun</option>
                                                @for ($i = DB::table('users')->min('grad'); $i <= DB::table('users')->max('grad'); $i++)
                                                @empty ($i) @else
                                                <option {{ isset($_GET['tahun']) && ($_GET['tahun'] == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                                                @endempty
                                                @endfor

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary" name="submit" value="submit">Terapkan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
                @if($users->total() == 0)
                {{ 'Tidak ada entri' }}
                @else
                {{ 'Menampilkan '.count($users).' dari '.$users->total() }}
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card shadow">
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Nama') }}</th>
                                <th scope="col">{{ __('Alamat') }}</th>
                                <th scope="col">{{ __('Jurusan') }}</th>
                                <th scope="col">{{ __('Tahun Lulus') }}</th>
                                <th scope="col">{{ __('Status Alumni') }}</th>
                                @if (auth()->user()->isAdmin())
                                <th scope="col"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td><a href="{{ route('user.show', $user->id) }}">{{ $user->name }}</a></td>
                                <td>
                                    {{ $user->street.', '.$user->getAddress().', '.$user->getSubDistrict().', '.$user->getDistrict().', '.$user->getProvince() }}
                                </td>
                                <td>
                                    {{ $user->department }}
                                </td>
                                <td>{{ $user->grad }}</td>
                                <td>
                                    @switch($user->alumniStatus())
                                    @case('Aktif')
                                    <span class="badge badge-success">{{ $user->alumniStatus() }}</span>
                                    @break
                                    @case('Belum Aktif')
                                    <span class="badge badge-warning">{{ $user->alumniStatus() }}</span>
                                    @break
                                    @case('Tidak Aktif')
                                    <span class="badge badge-danger">{{ $user->alumniStatus() }}</span>
                                    @break
                                    @default
                                    @endswitch
                                    
                                    @if (auth()->user()->isAdmin())
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if ($user->id != auth()->id())
                                                <form action="{{ route('user.destroy', $user) }}" method="post">
                                                    @csrf
                                                    @method('delete')

                                                    <a class="dropdown-item" href="{{ route('user.edit', $user) }}">{{ __('Edit') }}</a>
                                                    <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                                @else
                                                <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Edit') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $users->appends($_GET)->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
    @endsection
