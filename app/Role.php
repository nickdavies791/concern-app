<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
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
     * Returns the Users associated with a Role
     */
    public function users(){
        return $this->hasMany(User::class);
    }
}
