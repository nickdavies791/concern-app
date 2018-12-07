<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Concern extends Model
{
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

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

}
