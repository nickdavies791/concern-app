<?php

namespace App;

use GregoryDuckworth\Encryptable\EncryptableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
	use EncryptableTrait;
	use SoftDeletes;

	/**
	 * Encrypted Fields
	 * @var array
	 */
	protected $encryptable = [
		'body',
		'action_taken'
	];

	/**
	 * The attributes that are not mass assignable.
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * The attributes that are dates.
	 * @var array
	 */
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * Returns the concern associated with the comment
	 */
	public function concern()
	{
		return $this->belongsTo(Concern::class);
	}

	/**
	 * Returns the User associated with a Comment
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Return mutated created_at property
	 * @return mixed
	 */
	public function getPostedAtAttribute()
	{
		return $this->created_at->format('d M Y g:ia');
	}
}
