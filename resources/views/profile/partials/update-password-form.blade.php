<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            @lang('messages.updatep')
        </h2>

        <p class="text-muted mt-2">
            @lang('messages.passnoti')
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">
                @lang('messages.curr_pass')
            </label>
            <input type="password" id="update_password_current_password" name="current_password" class="form-control"
                autocomplete="current-password" />
            @if ($errors->updatePassword->has('current_password'))
            <div class="text-danger small mt-1">
                {{ $errors->updatePassword->first('current_password') }}
            </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">
                @lang('messages.newpass')
            </label>
            <input type="password" id="update_password_password" name="password" class="form-control"
                autocomplete="new-password" />
            @if ($errors->updatePassword->has('password'))
            <div class="text-danger small mt-1">
                {{ $errors->updatePassword->first('password') }}
            </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">
                @lang('messages.cpass')
            </label>
            <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                class="form-control" autocomplete="new-password" />
            @if ($errors->updatePassword->has('password_confirmation'))
            <div class="text-danger small mt-1">
                {{ $errors->updatePassword->first('password_confirmation') }}
            </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                @lang('messages.save')
            </button>

            @if (session('status') === 'password-updated')
            <p class="text-success small mb-0">
                @lang('messages.saved')
            </p>
            @endif
        </div>
    </form>
</section>