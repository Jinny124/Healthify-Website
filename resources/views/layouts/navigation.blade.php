<style>
  .dropdown-toggle::after {
    display: none;
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top py-2">
  <div class="container-fluid">

    {{-- Opens the sidebar drawer; only shown while the sidebar is off-canvas. --}}
    <button class="btn btn-link text-white px-2 d-lg-none" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="@lang('messages.home')">
      <i class="bi bi-list fs-3"></i>
    </button>

    <a class="navbar-brand d-flex align-items-center fw-bold me-0 me-lg-3" href="{{ route('threads.search') }}">
      <i class="bi bi-bandaid-fill text-primary fs-3 me-2"></i>Healthify
    </a>

    <button class="navbar-toggler border-0 ms-auto" type="button" data-bs-toggle="collapse"
      data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNavbar">

      <form class="d-flex align-items-center flex-grow-1 my-3 my-lg-0 mx-lg-3" method="GET"
        action="{{ route('threads.search') }}">
        <input class="form-control me-2" type="search" name="search" placeholder="@lang('messages.search...')"
          aria-label="@lang('messages.search...')">
        <input type="hidden" name="filter" value="search">
        <button class="btn btn-outline-success" type="submit">
          <i class="bi bi-search fw-bold"></i>
        </button>
      </form>

      <div class="d-flex align-items-center flex-wrap gap-2 pb-2 pb-lg-0">

        <!-- Language Selection -->
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false">
            @if (app()->getLocale() == 'id')
              <i class="flag-icon flag-icon-id"></i> Bahasa Indonesia
            @elseif (app()->getLocale() == 'jp')
              <i class="flag-icon flag-icon-jp"></i> 日本語
            @else
              <i class="flag-icon flag-icon-us"></i> English
            @endif
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li>
              <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                <i class="flag-icon flag-icon-us"></i> English
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('lang.switch', 'id') }}">
                <i class="flag-icon flag-icon-id"></i> Bahasa Indonesia
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('lang.switch', 'jp') }}">
                <i class="flag-icon flag-icon-jp"></i> 日本語
              </a>
            </li>
          </ul>
        </div>

        @if (Auth::check())
          <!-- Create Button -->
          <a class="btn btn-primary border-2 fw-bold" href="{{ route('threads.thread.create') }}">
            @lang('messages.create')
            <i class="bi bi-plus fw-bold"></i>
          </a>

          <!-- User Profile Dropdown -->
          <div class="dropdown">
            <div class="dropdown-toggle" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
              aria-expanded="false" aria-haspopup="true" style="cursor: pointer;">
              @if (Auth::user()->profile_photo_path)
                <img src="{{ Auth::user()->profile_photo_path }}" alt="Profile" class="rounded-circle" width="45"
                  height="45">
              @else
                <img src="{{ asset('ProfilePlaceholder.jpg') }}" alt="Profile" class="rounded-circle" width="45"
                  height="45">
              @endif
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
              @if (Auth::user()->isAdmin())
                <li>
                  <a class="dropdown-item text-danger fw-bold" href="{{ route('admin.doctors.index') }}">
                    <i class="bi bi-shield-check me-1"></i> Doctor verifications
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              @endif
              <li>
                <a class="dropdown-item text-primary fw-bold"
                  href="{{ route('profile.show', Auth::user()) }}">@lang('messages.profile')</a>
              </li>
              <li>
                <a class="dropdown-item text-primary fw-bold"
                  href="{{ route('profile.edit') }}">@lang('messages.settings')</a>
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item text-primary fw-bold">
                    @lang('messages.logout')
                  </button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <a class="btn btn-outline-primary border-2 fw-bold" href="{{ route('login') }}">@lang('messages.login')</a>
          <a class="btn btn-primary" href="{{ route('register') }}">@lang('messages.register')</a>
        @endif
      </div>
    </div>
  </div>
</nav>
