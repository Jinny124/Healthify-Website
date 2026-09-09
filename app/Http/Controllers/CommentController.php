<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'parent_comment_id' => 'nullable|exists:comments,id',
        ]);

        $parentCommentId = $validated['parent_comment_id'] ?? null;

        $threadId = $parentCommentId ? null : $thread->id;

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
            'thread_id' => $threadId, 
            'parent_comment_id' => $parentCommentId, 
        ]);

        return redirect()->route('threads.thread.show', $thread)
            ->with('success', 'Comment posted successfully.');
    }

    public function destroy( Comment $comment)
    {
        if(auth()->user()->id != $comment->user_id) {
            return response()->json(['error' => 'Unauthorized' , 'id' => auth()->user()->id , 'commentId' => $comment], 403);
        }

        $comment->delete();

        return back()->with('success','Comment deleted successfully.');
    }
}
