<?php

namespace App\Policies;

use App\Models\Vote;
use App\Models\User;

class VotePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Vote $vote): bool
    {
        // Users can view their own votes, or admins/organizers can view votes for their events
        return $user->id === $vote->user_id 
            || $user->isAdmin() 
            || $user->ownsEvent($vote->contestant->category->event);
    }

    /**
     * Determine if user can refund a vote
     */
    public function refund(User $user, Vote $vote): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can manually edit votes
     */
    public function edit(User $user, Vote $vote): bool
    {
        return $user->isAdmin();
    }
}