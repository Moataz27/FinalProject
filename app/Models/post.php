<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function like($user = null , $liked = true)
    {
        return $this->relation()->updateOrCreate([
            "user_id" => $user ? $user->id : auth()->id(),
            "tweet_id" => $this->id
        ],
        [
            "liked" => $liked
        ]);
    }

    public function dislike($user = null)
    {
        return $this->like($user,false);
    }

    public function isLikedBy(User $user)
    {
        return (bool) $user->likes->where("tweet_id", $this->id)->where("liked", true)->count();
    }

    public function isDislikedBy(User $user)
    {
        return (bool) $user->likes->where("tweet_id", $this->id)->where("liked", false)->count();
    }
    public function relation()
    {
        return $this->hasMany(Like::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class)->where('liked', true);
    }
    
    public function dislikes()
    {
        return $this->hasMany(Like::class)->where('liked', false);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
