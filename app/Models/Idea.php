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
        'status_id',
    ];

    // ====================================================================
    // PRIMARY RELATIONSHIPS
    // ====================================================================

    // Relationship: An idea belongs to a User (the author)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // NEW RELATIONSHIP: An idea belongs to a Status (e.g., Open, Implemented)
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    // Relationship: An idea has many comments
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relationship: An idea has many Votes (Upvotes) through the 'upvotes' pivot table
    public function votes(): BelongsToMany
    {
        // This links the Idea to the User model via the 'upvotes' table
        return $this->belongsToMany(User::class, 'upvotes');
    }
    
    // ====================================================================
    // HELPER METHODS
    // ====================================================================
    
    // Helper: Check if a given user has voted on this specific idea
    public function isVotedBy(?User $user): bool
    {
        // Returns false immediately if the user is a guest (null)
        if (!$user) {
            return false;
        }
        // Checks the votes relationship for a matching user_id
        return $this->votes()->where('user_id', $user->id)->exists();
    }
}
