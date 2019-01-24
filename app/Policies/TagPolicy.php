<?php

namespace App\Policies;

use App\User;
use App\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
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
     * Determine whether the user can view the Tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $Tag
     * @return mixed
     */
    public function view(User $user, Tag $Tag)
    {
        //
    }

    /**
     * Determine whether the user can create Tags.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSafeguarding();
    }

    /**
     * Determine whether the user can update the Tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $Tag
     * @return mixed
     */
    public function update(User $user, Tag $Tag)
    {
        return $user->isSafeguarding();
    }

    /**
     * Determine whether the user can delete the Tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $Tag
     * @return mixed
     */
    public function delete(User $user, Tag $Tag)
    {
        return $user->isSafeguarding();
    }

    /**
     * Determine whether the user can restore the Tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $Tag
     * @return mixed
     */
    public function restore(User $user, Tag $Tag)
    {
        return $user->isSafeguarding();
    }

    /**
     * Determine whether the user can permanently delete the Tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $Tag
     * @return mixed
     */
    public function forceDelete(User $user, Tag $Tag)
    {
        return $user->isSafeguarding();
    }
}
