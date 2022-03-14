@extends('layouts.app', ['title' => __('Daftar alumni')])

@section('content')
{{-- @include('layouts.headers.cards') --}}
@include('users.partials.header', ['title' => __('Daftar alumni')])

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <a class="btn btn-sm btn-primary" href="{{ route('user.create') }}">Tambah data</a>
            </div>
            <div class="mb-3">
                <form action="{{ route('user.index') }}" class="form-inline" method="GET">
                    <div class="input-group input-group-sm mb-2 mr-2">
                        <input type="text" name="nama" class="form-control" placeholder="Nama" aria-label="Nama" aria-describedby="search" value="{{ isset($_GET['nama']) ? $_GET['nama'] : ''  }}">
                    </div>
                    <div class="input-group input-group-sm mb-2 mr-2">
                        <select name="jurusan" id="jurusan" class="form-control">
                            <option value="">Semua Jurusan</option>
                            @foreach (\App\Department::all() as $department)
                            <option {{ isset($_GET['jurusan']) && ($_GET['jurusan'] == $department->code) ? 'selected' : '' }}value="{{ $department->code }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group input-group-sm mb-2 mr-2">
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            @foreach (\App\Status::all() as $status)
                            <option {{ isset($_GET['status']) && ($_GET['status'] == $status->id) ? 'selected' : '' }} value="{{ $status->id }}">{{ $status->status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group input-group-sm mb-2 mr-2">
                        <input type="number" name="tahun" class="form-control" placeholder="Tahun lulus" aria-label="Tahun lulus" aria-describedby="search" value="{{ isset($_GET['tahun']) ? $_GET['tahun'] : ''  }}">
                    </div>
                    <div class="input-group input-group-sm mb-2">
                        <button class="btn btn-primary btn-sm" type="submit" id="search"><i class="fa fa-search mr-2"></i>Cari</button>
                    </div>
                </form>
                
                <div>
                    @foreach ($_GET as $key => $value)
                    @if (!empty($value) && $key != 'submit' && $key != 'page')
                    <?php $link = str_replace($key.'='.$value, '', url()->full());
                    $link = str_replace('&&', '&', $link);
                    $link = str_replace('?&', '?', $link);
                    $value = $key == 'status' ? \App\Status::find($value)->status : $value;
                    $value = $key == 'gender' ? $value == 'M' ? 'Laki-laki' : 'Perempuan' : $value;
                    $value = $key == 'asal' ? \App\Location::getDistrict($value)->nama : $value;
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
            @if($users->total() == 0)
            <div class="alert alert-primary alert-dismissible fade show">
                {{ 'Tidak ada entri' }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @else
            <div class="alert alert-primary alert-dismissible fade show">
                {{ 'Menampilkan '.count($users).' dari '.$users->total() }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="card shadow">
                <div class="table-responsive">
                    <table class="table align-items-center table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ __('Nama') }}</th>
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
                                <td>{{ $user->department }}</td>
                                <td>{{ $user->grad }}</td>
                                <td>
                                    @switch($user->status)
                                    @case('Aktif')
                                    <span class="badge badge-success">{{ $user->status }}</span>
                                    @break
                                    @case('Belum Aktif')
                                    <span class="badge badge-warning">{{ $user->status }}</span>
                                    @break
                                    @case('Tidak Aktif')
                                    <span class="badge badge-danger">{{ $user->status }}</span>
                                    @break
                                    @default
                                    @endswitch
                                    
                                    @if (auth()->user()->isAdmin())
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            @if ($user->id != auth()->id())
                                            <form action="{{ route('user.destroy', $user) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                
                                                <a class="dropdown-item"
                                                href="{{ route('user.edit', $user) }}">{{ __('Edit') }}</a>
                                                <button type="button" class="dropdown-item"
                                                onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
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
    @endif
</div>

@include('layouts.footers.auth')
</div>
@endsection