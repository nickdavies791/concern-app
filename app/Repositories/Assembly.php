<?php

namespace App\Repositories;

use App\Token;
use GuzzleHttp\Client;

class Assembly {

    /**
     * Gets the Oauth details from the Assembly API
     * @param  string $code authorisation code
     * @return object Oauth token details
     */
    public function authorise($code){
        $response = (new Client())->post(config('services.assembly.auth_uri'), [
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
     * Refreshes access token in database
     * @param Token $token
     * @return boolean Success of refresh token
     */
    protected function refreshToken(Token $token){
        $response = (new Client())->post(config('services.assembly.auth_uri'), [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id' => config('services.assembly.client_id'),
                'client_secret' => config('services.assembly.client_secret'),
                'refresh_token' => $token->refresh_token,
            ]
        ]);

        $assembly = json_decode($response->getBody());

        $refreshedToken = $token->update([
            'secret' => $assembly->access_token
        ]);

        return $refreshedToken ? true : false;
    }


    /**
     * Configure the client to access SIMS API
     * @return Client
     */
    protected function configureClient(){
        $token = Token::first();

        if($token->expires_in){
            $this->refreshToken($token);
        }

        $client = new Client([
            'verify' => false,
            'headers' => [
                'Accept' => 'application/vnd.assembly+json; version=1',
                'Authorization' => 'Bearer '.$token->secret
            ]
        ]);

        return $client;
    }

    /**
     * Get student data from SIMS for all students
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStudents(){
        $client = $this->configureClient();
        $response = $client->request('GET', config('services.assembly.endpoint').'/students', [
            'form_params' => [
                'page' => '1',
                'per_page' => '1500',
                'demographics' => true,
                'ever_in_care' => true,
                'sen_needs' => true,
                'photo' => true,
            ]
        ]);
        return $response->getBody()->getContents();
    }

    /**
     * Gets the staff data from sims for teaching staff
     * @return object staff sims data
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getStaffMembers(){
        $client = $this->configureClient();
        $response = $client->request('GET', config('services.assembly.endpoint').'/staff_members', [
            'form_params' => [
                'page' => '1',
                'per_page' => '1500',
            ]
        ]);
        return $response->getBody()->getContents();
    }
}
