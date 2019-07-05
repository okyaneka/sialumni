<div class="header pt-7 pb-3">
    <!-- Mask -->
    <span class="mask bg-gradient-default opacity-8"></span>
    <!-- Header container -->
    <div class="container">
        <div class=" row d-flex align-items-center">
            <div class="col-md-12 {{ $class ?? '' }}">
                <h1 class="display-2 text-white">{{ $title }}</h1>
                @if (isset($description) && $description)
                <p class="text-white mt-0 mb-5">{{ $description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
