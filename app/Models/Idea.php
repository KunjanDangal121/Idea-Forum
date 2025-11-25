<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    // Relationship: An idea belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: An idea has many Votes (Upvotes)
    // We specifically name the table 'upvotes' because of your migration name
    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'upvotes');
    }
    
    // Helper: Check if a user voted
    public function isVotedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        return $this->votes()->where('user_id', $user->id)->exists();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
