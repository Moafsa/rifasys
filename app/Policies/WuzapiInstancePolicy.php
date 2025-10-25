<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WuzapiInstance;

class WuzapiInstancePolicy
{
    /**
     * Determine whether the user can view any instances.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the instance.
     */
    public function view(User $user, WuzapiInstance $instance): bool
    {
        return $user->id === $instance->user_id;
    }

    /**
     * Determine whether the user can create instances.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the instance.
     */
    public function update(User $user, WuzapiInstance $instance): bool
    {
        return $user->id === $instance->user_id;
    }

    /**
     * Determine whether the user can delete the instance.
     */
    public function delete(User $user, WuzapiInstance $instance): bool
    {
        return $user->id === $instance->user_id;
    }

    /**
     * Determine whether the user can restore the instance.
     */
    public function restore(User $user, WuzapiInstance $instance): bool
    {
        return $user->id === $instance->user_id;
    }

    /**
     * Determine whether the user can permanently delete the instance.
     */
    public function forceDelete(User $user, WuzapiInstance $instance): bool
    {
        return $user->id === $instance->user_id;
    }
}
