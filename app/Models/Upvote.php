<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upvote extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vote_type', 'votable_id', 'votable_type'];

    // Define polymorphic relation with any "votable" item (e.g., threads or comments)
    public function votable()
    {
        return $this->morphTo();
    }

    // Define the inverse relation with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
