<div class="d-flex align-items-center m-2">
    <a href="{{ route('profile.show', $object->user) }}">
        
        @if($object->user->profile_photo_path)
        <img src="{{ $object->user->profile_photo_path }}" alt="Button Image" class="rounded-circle my-2" width="50" height="50">
        
        @else
        <img src="{{ asset('ProfilePlaceholder.jpg') }}" alt="Button Image" class="rounded-circle my-2" width="50" height="50">
        @endif
        
    </a>
    <div class="d-flex flex-column ms-4">
        <a href="{{ route('profile.show', $object->user) }}" class="font-weight-bold fs-6 text-decoration-none">
            {{ $object->user->name }}
            @if($object->user->role == 'doctor')
            <span class="badge bg-primary font-weight-normal">@lang('messages.dokter')</span>
            @endif
        </a>
        <div class="text-muted">
            {{ $object->created_at->diffForHumans() }}
        </div>
    </div>
</div>