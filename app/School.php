<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
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
}
