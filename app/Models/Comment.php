<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'post_id',
    ];

    protected $casts = [
        'body' => 'array',
    ];


    public function post()
    {
        return $this->belongsToMany(Post::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_id');
    }
}
