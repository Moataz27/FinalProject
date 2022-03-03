<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'access_token',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates=[
        'created_at','updated_at'
    ];


    public function timeline()
    {
        $friends = $this->follows()->pluck('id');
        return Post::whereIn("user_id", $friends)
            ->orWhere("user_id", $this->id)
            ->withCount("likes", "dislikes")
            ->latest()
            ->get();
    }


    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }

    public function follow(User $user){
        return $this->follows()->save($user);
    }

    public function unfollow(User $user){
        return $this->follows()->detach($user);
    }

    public function togglefollow(User $user)
    {
        $this->follows()->toggle($user);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, "follows", "user_id", "following_user_id");
    }


    public function isFollowing(User $user)
    {
        return $this->follows()->where('following_user_id', $user->id)->exists();
    }

    // public function path($append = "")
    // {
    //     $route = route('profile.show', $this->user_name);

    //     return $append ? "{$route}/{$append}" : $route;
    // }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
