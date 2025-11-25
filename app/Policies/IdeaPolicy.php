<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Idea;

class IdeaPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Idea $idea): bool
    {
        // This is the core logic: The user's ID must match the idea's user_id.
        return $user->id === $idea->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Idea $idea): bool
    {
        // Reuse the same rule for deletion.
        return $user->id === $idea->user_id;
    }

    // You can keep the other default methods (view, create, etc.) if they were generated.
}
