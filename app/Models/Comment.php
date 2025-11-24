<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'idea_id',
        'body',
    ];

    // Relationship: A comment belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A comment belongs to an Idea
    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
