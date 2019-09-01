<?php

namespace App\Policies;

use App\User;
use App\CaffeineTrack;
use Illuminate\Auth\Access\HandlesAuthorization;

class CaffeineTrackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any caffeine tracks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the caffeine track.
     *
     * @param  \App\User  $user
     * @param  \App\CaffeineTrack  $caffeineTrack
     * @return mixed
     */
    public function view(User $user, CaffeineTrack $caffeineTrack)
    {
        return $user->id === $caffeineTrack->user_id;
    }

    /**
     * Determine whether the user can create caffeine tracks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the caffeine track.
     *
     * @param  \App\User  $user
     * @param  \App\CaffeineTrack  $caffeineTrack
     * @return mixed
     */
    public function update(User $user, CaffeineTrack $caffeineTrack)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the caffeine track.
     *
     * @param  \App\User  $user
     * @param  \App\CaffeineTrack  $caffeineTrack
     * @return mixed
     */
    public function delete(User $user, CaffeineTrack $caffeineTrack)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the caffeine track.
     *
     * @param  \App\User  $user
     * @param  \App\CaffeineTrack  $caffeineTrack
     * @return mixed
     */
    public function restore(User $user, CaffeineTrack $caffeineTrack)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the caffeine track.
     *
     * @param  \App\User  $user
     * @param  \App\CaffeineTrack  $caffeineTrack
     * @return mixed
     */
    public function forceDelete(User $user, CaffeineTrack $caffeineTrack)
    {
        return false;
    }
}
