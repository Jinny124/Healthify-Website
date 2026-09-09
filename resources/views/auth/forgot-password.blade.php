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
    <div class="border p-5 d bg-white rounded shadow" style="max-width: 25vw">
        <div class="d-flex justify-content-center mb-2">
            <i class="bi bi-person-raised-hand text-primary fs-1"></i>
        </div>
        <div class="mb-4 text-muted">
            <boldarea class="fw-bold text-primary">Forgot your password?</boldarea>
            We will email you a
            password
            reset link that will allow you to choose a new one.
        </div>


        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required
                    autofocus />
                @if($errors->has('email'))
                <label class="text-danger pt-1">{{ $errors->first('email') }}</label>
                @endif
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</body>