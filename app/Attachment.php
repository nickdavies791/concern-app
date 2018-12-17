<?php

namespace App;

use GregoryDuckworth\Encryptable\EncryptableTrait;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use EncryptableTrait;

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
    public function concern(){
        return $this->belongsTo(Concern::class);
    }
}
