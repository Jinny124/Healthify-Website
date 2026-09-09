<section class="mb-4">
    <header>
        <h2 class="h4 text-dark">
            @lang('messages.delacc')
        </h2>

        <p class="text-muted mt-2">
            @lang('messages.deletenoti')
        </p>
    </header>

    <!-- Delete Account Button -->
    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        @lang('messages.delacc')
    </button>

    <!-- Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                            @lang('messages.askdel')
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            @lang('messages.deletenoti')
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                @lang('messages.password')
                            </label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="{{ __('Password') }}" />
                            @if ($errors->userDeletion->has('password'))
                            <div class="text-danger small mt-1">
                                {{ $errors->userDeletion->first('password') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            @lang('messages.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('messages.delacc')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>