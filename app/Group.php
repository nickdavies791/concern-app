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
    * returns the users of a particular group
    */
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
