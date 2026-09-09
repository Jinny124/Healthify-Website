<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body','threads_image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
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

    public function sumVoteCount()
    {
        return $this->upvoteCount() - $this->downvoteCount();
    }
    
}
