<?php

namespace Alison\SlimBladeBlog\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
}