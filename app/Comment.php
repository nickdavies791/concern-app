<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;

class Comment extends Model
{
    use EncryptableTrait;

    /**
	 * Encrypted Fields
	 * @var array
	 */
	protected $encryptable = [
		'comment',
        'action_taken'
	];
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
    * returns the concern associated with the comment
    */
    public function concern(){
        return $this->belongsTo(Concern::class);
    }
}
