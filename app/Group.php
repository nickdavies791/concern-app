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
    * returns the users of a particular group
    */
    public function users(){
        return $this->hasMany(User::class);
    }
}
