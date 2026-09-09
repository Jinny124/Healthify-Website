@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-8 mx-auto text-center">
                <h1 class="mb-4">@lang('messages.aboutus')</h1>
                <p class="lead">
                    @lang('messages.aboutusintro')
                </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-heart-pulse me-2"></i>@lang('messages.for_doctors')</h5>
                        <p class="card-text">
                        @lang('messages.for_doctors_desc')
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-people me-2"></i>@lang('messages.for_users')</h5>
                        <p class="card-text">
                        @lang('messages.for_users_desc')
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-8 mx-auto text-center">
                <h2 class="text-primary"><i class="bi bi-stars me-2"></i>@lang('messages.our_mission')</h2>
                <p class="mt-3">
                @lang('messages.our_mission_desc')
                </p>
            </div>
        </div>
    </div>
@endsection
