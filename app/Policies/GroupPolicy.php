<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
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
	 * Determine whether the user can create Groups.
	 *
	 * @param  \App\User $user
	 * @return mixed
	 */
	public function create(User $user)
	{
		return $user->isSafeguarding();
	}

	/**
	 * Determine whether the user can update the Group.
	 *
	 * @param  \App\User $user
	 * @return mixed
	 */
	public function update(User $user)
	{
		return $user->isSafeguarding();
	}

	/**
	 * Determine whether the user can delete the Group.
	 *
	 * @param  \App\User $user
	 * @return mixed
	 */
	public function delete(User $user)
	{
		return $user->isSafeguarding();
	}
}
