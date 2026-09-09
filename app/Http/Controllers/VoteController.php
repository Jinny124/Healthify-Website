<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\Upvote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Request $request, $type, $id)
    {
        $request->validate([
            'vote_type' => 'required|in:upvote,downvote',
        ]);

        $model = null;
        if ($type === 'thread') {
            $model = Thread::findOrFail($id);
        } elseif ($type === 'comment') {
            $model = Comment::findOrFail($id);
        }

        $existingVote = Upvote::where('user_id', auth()->id())
            ->where('votable_id', $id)
            ->where('votable_type', $model::class)
            ->first();

        if ($existingVote) {
            $existingVote->update(['vote_type' => $request->vote_type]);
        } else {
            Upvote::create([
                'user_id' => auth()->id(),
                'vote_type' => $request->vote_type,
                'votable_id' => $id,
                'votable_type' => $model::class,
            ]);
        }

        return back();
    }
}
