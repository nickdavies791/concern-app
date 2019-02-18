<?php

namespace App;

use App\Repositories\Assembly;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
	/**
	 * The attributes that are not mass assignable.
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Checks if token has expired
	 * @param  string $value expires_in datetime value
	 * @return boolean
	 */
	public function getExpiresInAttribute($value)
	{
		return now() > $this->updated_at->addSeconds($value);
	}

	/**
	 * Authorise the application for using the SIMS API
	 * @param  string $code code returned in Assembly OAuth flow
	 * @return object OAuth details
	 */
	public function authorise($code)
	{
		return (new Assembly)->authorise($code);
	}
}
