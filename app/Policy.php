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
    * Disable created_at and updated_at fields.
    * @var boolean
    */
    public $timestamps = false;

    /**
    * returns users associated with a particular policy
    */
    public function users(){
        return $this->belongsToMany(User::class);
    }

    // public function getReadAtAttribute($value){
    //     return $thi
    // }
}
