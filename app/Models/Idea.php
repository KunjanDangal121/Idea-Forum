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
        'status_id', // Ensure this is fillable
    ];

    // Relationship: An idea belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // NEW: Relationship to Status (THIS WAS LIKELY MISSING)
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    // Relationship: An idea has many comments
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relationship: An idea has many Votes
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
}
