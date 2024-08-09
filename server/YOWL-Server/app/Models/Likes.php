<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;


    protected $fillable = [
        'post_id',
        'user_id'
    ];

    public function posts() : BelongsTo
    {
        return $this->belongsTo(Post::class, 'id');
    }

    public function users() : BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
}
