<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'role_id', 'staff_code', 'name', 'email', 'imported_at', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Return the Role associated with a User
	 */
	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	/**
	 * Returns documents associated with a user
	 */
	public function documents()
	{
		return $this->belongsToMany(Document::class)->withPivot('read_at');
	}

	/**
	 * returns the groups a user is associated with
	 */
	public function groups()
	{
		return $this->belongsToMany(Group::class);
	}

	/**
	 * returns the concerns a user is associated with
	 */
	public function concerns()
	{
		return $this->hasMany(Concern::class)->orderBy('created_at', 'DESC');
	}

	/**
	 * Check the User has the 'Admin' role type
	 * @return bool
	 */
	public function isAdmin()
	{
		return $this->role()->where('type', 'Admin')->exists();
	}

	/**
	 * Check the User has the 'Safeguarding' role type
	 * @return bool
	 */
	public function isSafeguarding()
	{
		return $this->role()->where('type', 'Safeguarding')->exists();
	}

	/**
	 * Check the User has the 'Staff' role type
	 * @return bool
	 */
	public function isStaff()
	{
		return $this->role()->where('type', 'Staff')->exists();
	}

	/**
	 * Check the User has the 'User' role type
	 * @return bool
	 */
	public function isUser()
	{
		return $this->role()->where('type', 'User')->exists();
	}
}
