@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row ">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    @if(Auth::user()->profile_photo_path)
                    <img src="{{ Auth::user()->profile_photo_path }}" alt="Button Image" class="rounded-circle my-2" width="100" height="100">
                    @else
                    <img src="{{ asset('ProfilePlaceholder.jpg') }}" alt="Button Image" class="rounded-circle my-2" width="100" height="100">
                    @endif
                    <div class="py-2 d-flex align-items-center">
                        <h4 class="me-2 mb-0">{{ $user->name }}</h4>
                        @if($user->role == 'doctor')
                        <span class="badge bg-primary font-weight-normal ms-2">@lang('messages.dokter')</span>
                        @endif
                    </div>
                    <p>@lang('messages.joined') {{ $user->created_at->diffForHumans() }}</p>
                </div>
                
                    
            </div>
        </div>

        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>@lang('messages.thread')</h4>
                </div>
                <div class="card-body">
                    @if($threads->isEmpty())
                    <p>@lang('messages.emptyt')</p>
                    @else
                    <ul class="list-group">
                        @foreach($threads as $thread)
                        <li class="list-group-item">
                            <h5><a href="{{ route('threads.thread.show', $thread->id) }}">{{ $thread->title }}</a></h5>
                            <p>{{ Str::limit($thread->body, 150) }}</p>
                            <small>Created on {{ $thread->created_at->format('F j, Y') }}</small>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>@lang('messages.comment')</h4>
                </div>
                <div class="card-body">
                    @if($comments->isEmpty())
                    <p>@lang('messages.emptyc')</p>
                    @else
                    <ul class="list-group">
                        @foreach($comments as $comment)
                        <li class="list-group-item">
                            <p><strong>Comment on:</strong>
                                @if($comment->thread)
                                <a href="{{ route('threads.thread.show', $comment->thread->id) }}">{{ $comment->thread->title }}</a>
                                @else
                                <span>No associated thread</span>
                                @endif
                            </p>
                            <small>Commented on {{ $comment->created_at->format('F j, Y') }}</small>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection