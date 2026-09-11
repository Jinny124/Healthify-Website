{{-- `offcanvas-lg` renders as a normal fixed column from the `lg` breakpoint up
     and as a slide-in drawer below it (toggled from the navbar hamburger). --}}
<div class="offcanvas-lg offcanvas-start app-sidebar d-flex flex-column shadow bg-dark" tabindex="-1"
    id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">

    <div class="offcanvas-header text-white d-lg-none">
        <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">
            <i class="bi bi-bandaid-fill text-primary me-2"></i>{{ config('app.name', 'Healthify') }}
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            data-bs-target="#sidebarOffcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column p-0">
        <div class="list-group list-group-flush flex-grow-1">
            <div
                class="d-flex align-items-center justify-content-center list-group-item list-group-item-action rounded-top bg-dark">
                <i class="bi bi-house-fill text-primary mx-2 fs-4"></i>
                <a href="{{ route('threads.search') }}"
                    class="fw-semibold fs-6 text-decoration-none text-white">@lang('messages.home')</a>
            </div>
            <div
                class="d-flex align-items-center justify-content-center list-group-item list-group-item-action bg-dark">
                <i class="bi bi-fire text-primary mx-2 fs-4"></i>
                <a href="{{ route('threads.search', ['filter' => 'popular']) }}"
                    class="fw-semibold fs-6 text-decoration-none text-white">@lang('messages.popular')</a>
            </div>
        </div>

        <div class="list-group list-group-flush">
            <div
                class="d-flex align-items-center justify-content-center list-group-item list-group-item-action bg-dark">
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
</div>
