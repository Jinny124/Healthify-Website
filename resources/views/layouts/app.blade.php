<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap-icons-1.11.3/font/bootstrap-icons.css') }}" rel="stylesheet">
</head>

<body class="custom-scrollbar">

    @include('layouts.navigation')

    <div class="d-flex" id="wrapper">

        <div class="" id="sidebar-wrapper" style="width: 400px;">
            @include('layouts.sidebar')
        </div>

        <div id="page-content-wrapper" class="container-fluid " style="margin-top: 70px;">
            @yield('content')
        </div>
    </div>
</body>

    
</script>
</html>