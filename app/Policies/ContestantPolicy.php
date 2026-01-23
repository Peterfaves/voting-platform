<?php

namespace App\Policies;

use App\Models\Contestant;
use App\Models\User;

class ContestantPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canManageEvents();
    }

    public function view(User $user, Contestant $contestant): bool
    {
        return $user->isAdmin() || $user->ownsEvent($contestant->category->event);
    }

    public function create(User $user): bool
    {
        return $user->canManageEvents();
    }

    public function update(User $user, Contestant $contestant): bool
    {
        return $user->isAdmin() || $user->ownsEvent($contestant->category->event);
    }

    public function delete(User $user, Contestant $contestant): bool
    {
        return $user->isAdmin() || $user->ownsEvent($contestant->category->event);
    }

    /**
     * Determine if user can evict contestants
     */
    public function evict(User $user, Contestant $contestant): bool
    {
        return $user->isAdmin() || $user->ownsEvent($contestant->category->event);
    }
}