<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_verified',
    ];
    //one user can like many post and one post can have like from many users
    public function likes()
    {
        return $this->belongsToMany(Post::class, 'likes')->withTimestamps();
    }
    //relationship with post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //who follow me 
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows', //table where this relation relevant
            'following_id', //me in the following id 
            'follower_id', //people who follow me 
        )->withTimestamps();
    }
    //whom i follow
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'following_id',
        )->withTimestamps();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
