@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
    @include('users.partials.header', [
        'title' => __('Halo') . ' '. auth()->user()->name,
        'description' => __('Halaman profil Sistem Informasi Alumni SMK Negeri Pringsurat'),
        'class' => 'col-lg-7',
    ])

<div class="container-fluid mt--5">
    <div class="row">
        <div class="col-xl-6 offset-xl-3 mb-5 mb-xl-0 mt-xl--7 ">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                    <img src="{{ asset('argon') }}/img/theme/user.png" class="rounded-circle">
                                </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary mr-4">{{ __('Edit profil') }}</a>
                    </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="text-center mt-md-7">
                        <h3>
                            {{ auth()->user()->name }}<span class="font-weight-light">, {{ \Carbon\Carbon::parse(auth()->user()->dob)->age }} tahun</span>
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{ __(auth()->user()->street.', '.auth()->user()->address.', '.auth()->user()->sub_district.', '.auth()->user()->district) }}
                        </div>
                        <div class="h5">
                            <i class="ni business_briefcase-24 mr-2"></i>{{ __('Lulusan tahun '.auth()->user()->grad) }}
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Tempat Lahir</div>
                            <div class="col text-right">{{ auth()->user()->pob }}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Tanggal Lahir</div>
                            <div class="col text-right">{{ auth()->user()->dob }}</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Jurusan</div>
                            <div class="col text-right">{{ \App\Department::where('code',auth()->user()->department)->first()->department }}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Tahun lulus</div>
                            <div class="col text-right">{{ auth()->user()->grad }}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Status</div>
                            <div class="col text-right">{{ \App\Status::where('code',auth()->user()->status)->first()->status }}</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Nomor Telepon</div>
                            <div class="col text-right">{{ auth()->user()->phone }}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Nomor Telegram</div>
                            <div class="col text-right">{{ auth()->user()->telegram }}</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Email</div>
                            <div class="col text-right"><a href="mailto:{{ auth()->user()->email }}">{{ auth()->user()->email }}</a></div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="col text-left">Link grup telegram</div>
                            <div class="col text-right">
                                <a href="{!! auth()->user()->group->link ?: '#' !!}" target="_blank">{{ auth()->user()->group->link ?: '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection
