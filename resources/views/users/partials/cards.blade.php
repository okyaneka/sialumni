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
    <div class="card-body pt-0 pt-md-4">
        <div class="text-center mt-md-7">
            <h3>
                {{ auth()->user()->name }}<span class="font-weight-light">, {{ \Carbon\Carbon::parse(auth()->user()->dob)->age }} tahun</span>
            </h3>
            <div class="h5 font-weight-300">
                <i class="ni pin-3 mr-2"></i>{{ __(auth()->user()->street.', '.auth()->user()->address.', '.auth()->user()->sub_district) }}
            </div>
            <div class="h5">
                <span>
                    Lulusan tahun {{ __(auth()->user()->grad) }} jurusan {{ auth()->user()->department }}
                </span>
            </div>
            <hr>
            <div class="h4"><span class="font-weight-light">Link grup telegram : </span><a href="{!! auth()->user()->group ?: '#' !!}">{{ auth()->user()->group ?: '-' }}</a></div>
        </div>
    </div>
</div>