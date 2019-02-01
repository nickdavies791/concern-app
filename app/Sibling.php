<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sibling extends Model
{
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
     * Retrieves students related to a sibling
     */
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
