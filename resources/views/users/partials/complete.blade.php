<div class="header pt-5 pt-md-8">
    @if (session('status'))
    <div class="mb-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('status') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif
    <div class="card bg-secondary shadow">
        <div class="card-header bg-white border-0">
            <div class="align-items-center">
                <h3 class="mb-0 text-warning"><i class="fa fa-fw fa-exclamation-triangle"></i> {{ __('Lengkapi Data Berikut') }}</h3>
            </div>
        </div>
        <div class="card-body">
            @include('users.partials.form', ['action' => route('home.update'), 'method' => 'post', 'user' => auth()->user()])
        </div>
    </div>

</div>
