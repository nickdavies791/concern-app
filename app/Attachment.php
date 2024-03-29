<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Attachment extends Model
{
	use EncryptableTrait, HasMediaTrait;

	/**
	 * Encrypted Fields
	 * @var array
	 */
	protected $encryptable = [
		'file_name'
	];

	/**
	 * The attributes that are not mass assignable.
	 * @var array
	 */
	protected $guarded = [];

	/**
	* Return the concerns associated with an attachment
	*/
	public function concern()
	{
		return $this->belongsTo(Concern::class);
	}
}
