<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Comment extends Model
{
    use HasApiTokens,HasFactory,Notifiable;

    protected $fillable = [
        'content',
        'post_id',
        'username',
        'parent_id'
    ];

    public function users() : BelongsTo
    {
        return $this->belongsTo(User::class, 'name');
    }
    public function categories() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'id');
    }
    

}
