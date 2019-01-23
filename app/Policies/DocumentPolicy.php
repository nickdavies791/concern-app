<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
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
     * Determine whether the user can create documents
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isSafeguarding();
    }

    /**
     * Determine whether the user can delete documents
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->isSafeguarding();
    }
}
