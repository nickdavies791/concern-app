<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;


class Concern extends Model
{
    use EncryptableTrait;

    /**
	 * Encrypted Fields
	 * @var array
	 */
	protected $encryptable = [
	    'title'
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
    * return comments associated with a concern
    */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /**
    * return students associated with a concern
    */
    public function students(){
        return $this->belongsToMany(Student::class);
    }

    /**
    * return users associated with a concern
    */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Return mutated created_at property
     * @return mixed
     */
    public function getReportedAtAttribute(){
        return $this->created_at->format('d M Y g:ia');
    }

    /**
     * Return all unresolved concerns in latest order
     * @param $query
     * @return mixed
     */
    public function scopeLatestUnresolved($query)
    {
        return $query->where('resolved_on', null)->latest();
    }

}
