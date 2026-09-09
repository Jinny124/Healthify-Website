
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
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="border p-5 d bg-white rounded shadow" style="min-width: 20vw">
        @csrf
        <div class="d-flex justify-content-center mb-2">
            <i class="bi bi-capsule text-primary fs-1"></i>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">@lang('messages.name')</label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus
                autocomplete="name" />
            @if($errors->has('name'))
            <label class="text-danger pt-1">{{ $errors->first('name') }}</label>
            @endif
        </div>


        <div class="mb-3">
            <label for="email" class="form-label">@lang('messages.email')</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required
                autocomplete="username" />
            @if($errors->has('email'))
            <label class="text-danger pt-1">{{ $errors->first('email') }}</label>
            @endif
        </div>


        <div class="mb-3">
            <label for="role" class="form-label">@lang('messages.role')</label>
            <select id="role" name="role" class="form-select" required onchange="toggleDoctorCertificate()">
                <option value="normal_user">@lang('messages.normal')</option>
                <option value="doctor">@lang('messages.dokter')</option>
            </select>
            @if($errors->has('role'))
            <label class="text-danger pt-1">{{ $errors->first('role') }}</label>
            @endif
        </div>


        <div id="doctor-certificate-container" class="mb-3 d-none">
            <label for="doctor_certificate" class="form-label">@lang('messages.certi')</label>
            <input id="doctor_certificate" class="form-control" type="file" name="doctor_certificate" />
            @if($errors->has('doctor_certificate'))
            <label class="text-danger pt-1">{{ $errors->first('doctor_certificate') }}</label>
            @endif
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">@lang('messages.password')</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="" />
            @if($errors->has('password'))
            <label class="text-danger pt-1">{{ $errors->first('password') }}</label>

            @endif
        </div>


        <div class="mb-3">
            <label for="password_confirmation" class="form-label">@lang('messages.cpass')</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required
                autocomplete="" />
            @if($errors->has('password_confirmation'))
            <label class="text-danger pt-1">{{ $errors->first('password_confirmation') }}</label>
            @endif
        </div>

        <div class="d-flex justify-content-end mt-3">
            <a class="text-muted text-decoration-none me-3" href="{{ route('login') }}">
                @lang('messages.registered')
            </a>

            <button type="submit" class="btn btn-primary">
                @lang('messages.register')
            </button>
        </div>
    </form>

    <script>
        function toggleDoctorCertificate() {
            const role = document.getElementById('role').value;
            const certificateContainer = document.getElementById('doctor-certificate-container');
            
            if (role === 'doctor') {
                certificateContainer.classList.remove('d-none');

                setTimeout(() => {
                    certificateContainer.classList.add('fade', 'show');
                }, 10); 
            } else {

                certificateContainer.classList.remove('show');
                certificateContainer.classList.add('fade');
            
                setTimeout(() => {
                    certificateContainer.classList.add('d-none');
                }, 200); 
            }
        }
    </script>
</body>