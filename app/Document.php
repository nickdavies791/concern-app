<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
    * Returns users associated with a document
    */
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
