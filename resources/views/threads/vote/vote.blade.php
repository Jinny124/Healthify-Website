<div class="" >
    <div class="d-flex justify-content-between align-items-center ">

        <div class="d-flex align-items-center my-2">
            <form action="{{ route('vote', ['type' => $type, 'id' => $object->id]) }}" method="POST">
                @csrf
                @if(Auth::check())
                <button type="submit" name="vote_type" value="upvote" class="btn btn-primary p-2 ">
                    <i class="bi bi-caret-up-fill"></i>
                </button>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary p-2 ">
                    <i class="bi bi-caret-up-fill"></i>
                </a>
                @endif
            </form>
    
            <p class="mx-2 mb-0 ">{{ $object->upvoteCount() - $object->downvoteCount() }}</p>
    
            <form action="{{ route('vote', ['type' => $type, 'id' => $object->id]) }}" method="POST">
                @csrf
                @if(Auth::check())
                <button type="submit" name="vote_type" value="downvote" class="btn btn-primary p-2">
                    <i class="bi bi-caret-down-fill"></i>
                </button>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary p-2">
                    <i class="bi bi-caret-down-fill"></i>
                </a>
                @endif
            </form>
            @if(Auth ::check())
            <a class="btn btn-primary d-flex ms-2 align-self-stretch" data-bs-toggle="collapse"
                href="#collapseComment-{{$object->id}}" role="button" aria-expanded="false"
                aria-controls="collapseComment-{{$object->id}}">
    
    
                <i class="bi-chat"></i>
                @if ($object->childComments && $object->childComments->isNotEmpty())
                <div class="ms-2">
                    {{ $object->childComments->count() }}
                </div>
                @endif
                @if ($object->comments && $object->comments->isNotEmpty())
                <div class="ms-2">
                    {{ $object->comments->count() }}
                </div>
                @endif
            </a>
            @endif
            
        </div>
        @if($object instanceof App\Models\Thread)
        @include('threads.vote.delete', ['object' => $object , 'type' => 'thread'])
        @elseif($object instanceof App\Models\Comment)
        @include('threads.vote.delete', ['object' => $object , 'type' => 'comment'])
        @endif
    </div>
 
    <div class="collapse " id="collapseComment-{{$object->id}}">

        @if ($object instanceof App\Models\Thread)
        <form action="{{ route('comments.store', $thread) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="body" class="form-control" placeholder="Write a comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>
        @endif
        @if ($object instanceof App\Models\Comment)
        <form action="{{ route('comments.store', $thread) }}" method="POST">
            @csrf
            <div class="mb-3">
                <textarea name="body" class="form-control" placeholder="Write a reply..." required></textarea>
            </div>
            <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
            <button type="submit" class="btn btn-primary">Reply</button>
        </form>
        @endif
    </div>
  
</div>