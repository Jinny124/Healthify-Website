<style>
  .dropdown-toggle::after {
    display: none;
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

<nav class="navbar navbar-expand-lg navbar-dark p-2 bg-dark" style="position: fixed; z-index: 1050; width: 100%; top: 0; left: 0;">
  <div class="container-fluid">
    <div class="navbar-brand d-flex align-items-center justify-content-center">
      <i class="bi bi-bandaid-fill text-primary fs-2 me-2"></i>
      <a class="navbar-brand fw-bold text-white" href="/">Healthify</a>
    </div>

    <div class="mx-auto" style="flex-grow: 1; max-width: 60%;">
      <form class="d-flex align-items-center" method="GET" action="{{ route('threads.search') }}">
        <input class="form-control me-2" style="width: 100%;" type="search" name="search" placeholder="@lang('messages.search...')" aria-label="Search">
        <input type="hidden" name="filter" value="search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
          <i class="bi bi-search fw-bold"></i>
        </button>
      </form>
    </div>

    <div class="d-flex align-items-center ms-auto">
      <!-- Language Selection -->
      <div class="dropdown me-3">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        @if (app()->getLocale() == 'id')
            <i class="flag-icon flag-icon-id"></i> Bahasa Indonesia
        @elseif (app()->getLocale() == 'jp')
            <i class="flag-icon flag-icon-jp"></i> 日本語
        @else
            <i class="flag-icon flag-icon-us"></i> English
        @endif
    </button>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
            <i class="flag-icon flag-icon-us"></i> English
        </a>
        <a class="dropdown-item" href="{{ route('lang.switch', 'id') }}">
            <i class="flag-icon flag-icon-id"></i> Bahasa Indonesia
        </a>
        <a class="dropdown-item" href="{{ route('lang.switch', 'jp') }}">
            <i class="flag-icon flag-icon-jp"></i> 日本語
        </a>
    </ul>
</div>


      <!-- Create Button -->
      @if(Auth::check())
      <a class="btn btn-primary border-2 fw-bold me-3" href="/threads/create">
        @lang('messages.create')
        <i class="bi bi-plus fw-bold"></i>
      </a>

      <!-- User Profile Dropdown -->
      <div class="dropdown">
        <div class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
          @if(Auth::user()->profile_photo_path)
            <img src="{{ Auth::user()->profile_photo_path }}" alt="Button Image" class="rounded-circle my-2" width="45" height="45">
          @else
            <img src="{{ asset('ProfilePlaceholder.jpg') }}" alt="Button Image" class="rounded-circle my-2" width="45" height="45">
          @endif
        </div>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
          <li>
            <a class="dropdown-item text-primary fw-bold" href="{{ route('profile.show', Auth::user()) }}">@lang('messages.profile')</a>
          </li>
          <li>
            <a class="btn text-primary fw-bold dropdown-item" href="/profile">@lang('messages.settings')</a>
          </li>
          <li>
            <form method="POST" class="" action="{{ route('logout') }}">
              @csrf
              <a class="btn text-primary fw-bold dropdown-item" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                @lang('messages.logout')
              </a>
            </form>
          </li>
        </ul>
      </div>
      @else
      <div class="">
        <a class="btn btn-outline-primary border-2 fw-bold" href="/login">@lang('messages.login')</a>
        <a class="btn btn-primary ms-2" href="/register">@lang('messages.register')</a>
      </div>
      @endif
    </div>
  </div>
</nav>