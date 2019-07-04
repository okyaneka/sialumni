<div class="card card-profile shadow mt-lg-0 mt-md-7">
    <div class="row justify-content-center">
        <div class="col-lg-3 order-lg-2">
            <div class="card-profile-image">
                <a href="#">
                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" class="rounded-circle">
                </a>
            </div>
        </div>
    </div>
    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
        <div class="d-flex justify-content-between">
            @if(Request::is('user*'))
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary mr-4">{{ __('Kembali') }}</a>
            @endif

            @if (auth()->user()->id == $user->id)
            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-default float-right">{{ __('Edit profil') }}</a>
            @endif

            @if (auth()->user()->isAdmin())
            <a href="{{ route('user.edit', $user) }}" class="btn btn-sm btn-default float-right">{{ __('Edit alumni') }}</a>
            @endif
        </div>
    </div>
    <div class="card-body pt-0 pt-md-4">
        <div class="text-center mt-md-5">
            @if (Auth::user()->nis == $user->nis || Auth::user()->isAdmin())
            <h4>
                NIS : {{ $user->nis }}
            </h4>
            @endif
            <h3>
                {{ $user->name }}<span class="font-weight-light">, {{ \Carbon\Carbon::parse($user->dob)->age }} tahun</span>
            </h3>
            <div class="h5 font-weight-300">
                <i class="ni location_pin mr-2"></i>{{ __($user->street.', '.$user->getAddress().', '.$user->getSubDistricts().', '.$user->getDistricts()).', '.$user->getProvinces() }}
            </div>
            <div class="h5">
                <i class="ni business_briefcase-24 mr-2"></i>{{ __('Lulusan tahun '.$user->grad) }}
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">Tempat Lahir</div>
                <div class="col text-right">{{ $user->pob }}</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">Tanggal Lahir</div>
                <div class="col text-right">{{ $user->dob }}</div>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">Jurusan</div>
                <div class="col text-right">{{ \App\Department::where('code',$user->department)->first()->department }}</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">Tahun lulus</div>
                <div class="col text-right">{{ $user->grad }}</div>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left"><strong>Status</strong></div>
            </div>
            <?php $statuses = $user->statuses()->get() ?>
            @foreach ($statuses as $status)
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">
                    {{ $status->status }}
                    @if (!empty($status->pivot->info))
                    di <strong>{{ $status->pivot->info }}</strong>
                    @endif
                    @if (!empty($status->pivot->year))
                    sampai {{ $status->pivot->year }}
                    @endif
                </div>
            </div>
            @endforeach
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">Nomor Telepon</div>
                <div class="col text-right">{{ $user->phone }}</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">Email</div>
                <div class="col text-right"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
            </div>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <div class="col text-left">Link grup telegram</div>
                <div class="col text-right">
                    @isset (\App\Setting::get()['grouplink'])
                    <a href="{!! \App\Setting::get()['grouplink'] !!}" target="_blank">{{ substr(\App\Setting::get()['grouplink'] ,0,25).'...' }}</a>
                    @else
                    <span class="text-muted">Belum terdapat link grup yang terdaftar</span>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>