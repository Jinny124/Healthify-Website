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

    @include('layouts.sidebar')

    <div class="d-flex" id="wrapper">

        {{-- Holds the width of the fixed sidebar on large screens; collapses to
             zero below `lg`, where the sidebar becomes an off-canvas drawer. --}}
        <div id="sidebar-spacer"></div>

        <div id="page-content-wrapper" class="container-fluid">
            @yield('content')
        </div>
    </div>
</body>

</html>
