<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;

class Student extends Model
{
    use EncryptableTrait;

    /**
	 * Encrypted fields
	 * @var array
	 */
	protected $encryptable = [
		'forename',
		'surname',
        'upn',
        'admission_number'
	];

    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
    * Retrieves the concerns about a particular student.
    */
    public function concerns(){
        return $this->belongsToMany(Concern::class);
    }
}
