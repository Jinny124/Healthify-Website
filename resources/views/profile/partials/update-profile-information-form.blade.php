<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            @lang('messages.pinformation')
        </h2>

        <p class="text-muted mt-2">
            @lang('messages.updatenoti')
        </p>
    </header>

    <!-- Verification Form -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
        @csrf
    </form>

    <!-- Profile Update Form -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">@lang('messages.name')</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                required autofocus autocomplete="name" />
            @if ($errors->has('name'))
            <div class="text-danger small mt-1">
                {{ $errors->first('name') }}
            </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">@lang('messages.email')</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}"
                required autocomplete="username" />
            @if ($errors->has('email'))
            <div class="text-danger small mt-1">
                {{ $errors->first('email') }}
            </div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mt-3">
                <p class="text-muted small">
                    @lang('messages.notverified')

                    <button form="send-verification" class="btn btn-link p-0 text-decoration-none">
                        @lang('messages.resend')   
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="text-success small mt-2">
                    @lang('messages.resendfinish')
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="mb-3 ">
            <label for="name" class="form-label">@lang('messages.profilepicture')</label>


            <input type="file" name="profile_image" id="profile_image" class="form-control" type="file"
                accept="image/*"></input>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                @lang('messages.save')
            </button>

            @if (session('status') === 'profile-updated')
            <p class="text-success small mb-0">
                @lang('messages.saved')
            </p>
            @endif
        </div>
    </form>
</section>