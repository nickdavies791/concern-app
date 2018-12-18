<?php

namespace App\Policies;

use App\Concern;
use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
     * Determine whether the user can create comments.
     *
     * @param  \App\User $user
     * @param Concern $concern
     * @return mixed
     */
    public function create(User $user, Concern $concern)
    {
        if ($user->isEditor()) {
            dd($concern->comments);
        }
    }
}
