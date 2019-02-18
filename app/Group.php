<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	/**
	 * The attributes that are not mass assignable.
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Disable created_at and updated_at fields.
	 * @var boolean
	 */
	public $timestamps = false;

	/**
	 * Returns the users associated with a group
	 */
	public function users()
	{
		return $this->belongsToMany(User::class);
	}

	/**
	 * Assign users in groups to the selected document
	 * @param array $groups
	 * @param string $id
	 */
	public function assignDocuments(array $groups, string $id)
	{
		foreach ($groups as $group) {
			foreach ($this->find($group)->users as $user) {
				try {
					$user->documents()->attach($id);
				} catch (\Exception $e) {
					\Log::info("User already has this document", ['Error' => $e]);
				}
			}
		}
	}
}
