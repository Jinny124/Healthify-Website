@extends('layouts.app')

@section('header')
<h2 class="fw-semibold text-xl text-dark-emphasis">
    @lang('messages.profile')
</h2>
@endsection

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    <header>

                        @if(Auth::user()->profile_photo_path)
                        <img src="{{ Auth::user()->profile_photo_path }}" alt="Button Image" class="rounded-circle my-2" width="100" height="100">
                        @else
                        <img src="{{ asset('ProfilePlaceholder.jpg') }}" alt="Button Image" class="rounded-circle my-2" width="100" height="100">
                        @endif

                        <h2 class="h4 text-dark d-flex align-items-center mt-2">
                            @if(Auth::user()->role == 'doctor')
                            <span class="badge bg-primary font-weight-normal me-2">@lang('messages.dokter')</span>
                            @endif
                            {{Auth::user()->name}}
                        </h2>
                        <p class="text-muted">
                            @lang('messages.welcome') {{Auth::user()->name}} 
                        </p>
                    </header>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

        </div>
    </div>
</div>
    @endsection