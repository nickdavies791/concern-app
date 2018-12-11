<?php

namespace App;

use App\Repositories\Assembly;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
     * checks if token has expired
     * @param  string $value expires_in datetime value
     * @return boolean
     */
    public function getExpiresInAttribute($value){
        return now() > $this->updated_at->addSeconds($value);
    }

    /**
     * authorises the application for using the sims api
     * @param  string $code code returned in assembly oauth flow
     * @return object Oauth details
     */
    public function authorise($code){
        return (new Assembly)->authorise($code);
    }
}
