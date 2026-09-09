@if($type == 'thread')
<div class="d-flex align-items-center justify-content-center " role="group">
    @if(Auth::check() && Auth::user()->id == $object->user_id)
    <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#confirmThreadDeletionModal">
        <i class="bi bi-trash"></i>
    </button>
    <div class="modal fade" id="confirmThreadDeletionModal" tabindex="-1"
        aria-labelledby="confirmThreadDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" action="{{ route('threads.destroy', $object) }}" method="POST">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmThreadDeletionModalLabel">
                            Are you sure you want to delete this thread?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Delete Thread
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@elseif($type == 'comment')
<div class="d-flex align-items-center justify-content-center " role="group">
    @if(Auth::check() && Auth::user()->id == $object->user_id)
    <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#confirmCommentDeletionModal">
        <i class="bi bi-trash"></i>
    </button>
    <div class="modal fade" id="confirmCommentDeletionModal" tabindex="-1"
        aria-labelledby="confirmCommentDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="" action="{{ route('comments.destroy', $object) }}" method="POST">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmCommentDeletionModalLabel">
                            Are you sure you want to delete this comment?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            Delete comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endif