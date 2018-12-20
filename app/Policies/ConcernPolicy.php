<?php

namespace App\Policies;

use App\User;
use App\Concern;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConcernPolicy
{
    use HandlesAuthorization;

    /**
     * Perform initial checks before all other checks
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view all concerns
     * @param User $user
     * @return bool
     */
    public function viewAll(User $user)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can view their own concerns
     * @param User $user
     * @return bool
     */
    public function viewOwn(User $user)
    {
        return $user->isContributor() || $user->isEditor();
    }

    /**
     * Determine whether the user can view the concern.
     *
     * @param  \App\User  $user
     * @param  \App\Concern  $concern
     * @return mixed
     */
    public function view(User $user, Concern $concern)
    {
        if ($user->isContributor() || $user->isEditor()) {
            return $user->concerns->contains($concern->id);
        }
    }

    /**
     * Determine whether the user can create concerns.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isContributor() || $user->isEditor();
    }

    /**
     * Determine whether the user can update the concern.
     *
     * @param  \App\User  $user
     * @param  \App\Concern  $concern
     * @return mixed
     */
    public function update(User $user, Concern $concern)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can delete the concern.
     *
     * @param  \App\User  $user
     * @param  \App\Concern  $concern
     * @return mixed
     */
    public function delete(User $user, Concern $concern)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can restore the concern.
     *
     * @param  \App\User  $user
     * @param  \App\Concern  $concern
     * @return mixed
     */
    public function restore(User $user, Concern $concern)
    {
        return $user->isEditor();
    }

    /**
     * Determine whether the user can permanently delete the concern.
     *
     * @param  \App\User  $user
     * @param  \App\Concern  $concern
     * @return mixed
     */
    public function forceDelete(User $user, Concern $concern)
    {
        return $user->isEditor();
    }
}
