<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
     * Return the concerns associated with a tag
     */
    public function concerns()
    {
        return $this->belongsToMany(Concern::class);
    }
}
