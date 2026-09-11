{{-- Fixed rail from the `lg` breakpoint up. Below it the same links live in
     the navbar menu instead (see layouts/navigation.blade.php). --}}
<div class="app-sidebar d-none d-lg-flex flex-column shadow bg-dark">
    <div class="list-group list-group-flush flex-grow-1">
        <div
            class="d-flex align-items-center justify-content-center list-group-item list-group-item-action rounded-top bg-dark">
            <i class="bi bi-house-fill text-primary mx-2 fs-4"></i>
            <a href="{{ route('threads.search') }}"
                class="fw-semibold fs-6 text-decoration-none text-white">@lang('messages.home')</a>
        </div>
        <div class="d-flex align-items-center justify-content-center list-group-item list-group-item-action bg-dark">
            <i class="bi bi-fire text-primary mx-2 fs-4"></i>
            <a href="{{ route('threads.search', ['filter' => 'popular']) }}"
                class="fw-semibold fs-6 text-decoration-none text-white">@lang('messages.popular')</a>
        </div>
    </div>

    <div class="list-group list-group-flush">
        <div class="d-flex align-items-center justify-content-center list-group-item list-group-item-action bg-dark">
            <i class="bi bi-info-circle text-primary mx-2 fs-4"></i>
            <a href="{{ route('aboutus') }}"
                class="fw-semibold fs-6 text-decoration-none text-white">@lang('messages.about_us')</a>
        </div>
        <div
            class="d-flex align-items-center justify-content-center list-group-item list-group-item-action rounded-bottom bg-dark">
            <i class="bi bi-question-circle text-primary mx-2 fs-4"></i>
            <a href="{{ route('help') }}"
                class="fw-semibold fs-6 text-decoration-none text-white">@lang('messages.help')</a>
        </div>
    </div>
</div>
