<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine whether the user can create Users.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isSafeguarding();
    }

    /**
     * Determine whether the user can update Users.
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->isSafeguarding();
    }

    /**
     * Determine whether the user can delete Users.
     *
     * @param User $user
     */
    public function delete(User $user)
    {
        $user->isSafeguarding();
    }
}
