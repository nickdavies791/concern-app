<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
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
