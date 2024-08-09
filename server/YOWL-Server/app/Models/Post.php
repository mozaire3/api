<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'url', 
        'category_id',
        'notation',
        'user_id'
    ];

    public function users() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function likes()
    {
        return $this->hasMany(Likes::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
