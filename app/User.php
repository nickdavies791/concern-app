<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * returns policies associated with user
    */
    public function policies(){
        return $this->belongsToMany(Policy::class);
    }

    /**
    * returns the groups a user is associated with
    */
    public function groups(){
        return $this->belongsToMany(Group::class);
    }

    /**
    * returns the concerns a user is associated with
    */
    public function concerns(){
        return $this->hasMany(Concern::class);
    }
}
