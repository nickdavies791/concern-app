<?php

namespace App;

use App\Services\Interfaces\MISInterface;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
	 * The attributes that are not mass assignable.
     *
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Check if token has expired.
     *
	 * @param  string $value expires_in datetime value
	 * @return boolean
	 */
	public function getExpiresInAttribute($value)
	{
		return now() > $this->updated_at->addSeconds($value);
	}

    /**
     * Authorise the application to use MIS service.
     *
     * @param MISInterface $mis
     * @param  string $code code returned in OAuth flow
     * @return object OAuth details
     */
	public function authorise(MISInterface $mis, $code)
	{
		return $mis->authorise($code);
	}
}
