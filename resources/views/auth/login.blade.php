<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('Login', 'Login') }}</title>

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}" rel="stylesheet">
</head>

<body class="container d-flex justify-content-center align-items-center bg-primary" style="min-height: 100vh;">


    <form method="POST" action="{{ route('login') }}" class="border p-5 d bg-white rounded shadow"
        style="min-width: 25vw ; min-height: auto">
        @csrf
        <div class="d-flex justify-content-center mb-2">
            <i class="bi bi-door-open text-primary fs-1"></i>
        </div>
        <div class="">
            <div class="mb-3">
                <label for="email" class="form-label">@lang('messages.email')</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required
                    autofocus autocomplete="username" />
                @if($errors->has('email'))
                <label class="text-danger pt-1">{{ $errors->first('email') }}</label>
                @endif
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">@lang('messages.password')</label>
                <input id="password" class="form-control" type="password" name="password" required
                    autocomplete="current-password" />
                @if($errors->has('password'))
                <label class="text-danger pt-1">{{ $errors->first('password') }}</label>
                @endif
            </div>

            <div class="form-check mb-3">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-muted">@lang('messages.remember')</label>
            </div>

            <div class="d-flex justify-content-end mt-3 align-items-center ">
                @if (Route::has('password.request'))
                <a class="text-muted  me-3 " href="{{ route('password.request') }}">
                    @lang('messages.forgor')
                </a>
                @endif

                <p class="mt-3 me-1">@lang('messages.dont_have_account')</p>
                <a class="me-1" href="{{ route('register') }}">
                    @lang('messages.register')
                </a>
                <p class="mt-3  me-3 ">@lang('messages.here')</p>

                <button type="submit" class="btn btn-primary">
                    @lang('messages.login')
                </button>
            </div>
        </div>
    </form>
</body>