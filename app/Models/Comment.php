<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'thread_id', 'parent_comment_id', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function childComments()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }
    public function upvotes()
    {
        return $this->morphMany(Upvote::class, 'votable');
    }
    public function upvoteCount()
    {
        return $this->upvotes()->where('vote_type', 'upvote')->count();
    }

    public function downvoteCount()
    {
        return $this->upvotes()->where('vote_type', 'downvote')->count();
    }
}
