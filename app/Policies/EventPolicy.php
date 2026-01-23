<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Determine if user can view any events
     */
    public function viewAny(User $user): bool
    {
        return $user->canManageEvents();
    }

    /**
     * Determine if user can view the event
     */
    public function view(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->ownsEvent($event);
    }

    /**
     * Determine if user can create events
     */
    public function create(User $user): bool
    {
        return $user->canManageEvents();
    }

    /**
     * Determine if user can update the event
     */
    public function update(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->ownsEvent($event);
    }

    /**
     * Determine if user can delete the event
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->ownsEvent($event);
    }

    /**
     * Determine if user can restore the event
     */
    public function restore(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can permanently delete the event
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if user can manage event settings
     */
    public function manageSettings(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->ownsEvent($event);
    }
}