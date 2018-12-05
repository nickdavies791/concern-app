<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
    * returns users associated with a particular policy
    */
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
