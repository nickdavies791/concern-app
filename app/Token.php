<?php

namespace App;

use GuzzleHttp\Client;
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
     * @return object       Oauth details
     */
    public function authorise($code){
        $response = (new Client())->post('https://platform.assembly.education/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.assembly.client_id'),
                'client_secret' => config('services.assembly.client_secret'),
                'redirect_uri' => config('services.assembly.redirect_uri'),
                'code' => $code,
            ],
        ]);

        return json_decode($response->getBody());
    }

    /**
     * refreshes sims access token
     * @return boolean true if token refreshed properly
     */
    public function refresh(){
        $response = (new Client())->post('https://platform.assembly.education/oauth/token', [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id' => config('services.assembly.client_id'),
                'client_secret' => config('services.assembly.client_secret'),
                'refresh_token' => $this->refresh_token,
            ]
        ]);

        $assembly = json_decode($response->getBody());

        $refreshedToken = $this->update([
            'secret' => $assembly->access_token
        ]);

        return $refreshedToken ? true : false;
    }
}
