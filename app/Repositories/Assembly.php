<?php

namespace App\Repositories;

use App\Token;
use GuzzleHttp\Client;

class Assembly {

    /**
     * Gets the Oauth details from the Assembly api
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
     * Configures the Assembly API Client
     * @return AssemblyApi Instance of Assembly API Client
     */
    protected function configureClient(){
        $token = Token::first();

        if($token->expires_in){
            $this->refreshToken($token);
        }

        $client = new Client([
            'headers' => [
                'Accept' => 'application/vnd.assembly+json; version=1',
                'Authorization' => 'Bearer '.$token->secret
            ]
        ]);

        return $client;
    }

    /**
     * Gets the student data from SIMS for all students
     * @return object student sims data
     * @throws \Assembly\Client\ApiException
     */
    public function getStudents(){
        $client = $this->configureClient();
        $response = $client->request('GET', 'https://api.assembly.education/students?page=1&per_page=1500&demographics=true&sen_needs=true&photo=true');

        return $response->getBody()->getContents();
    }

    /**
     * Gets the staff data from sims for teaching staff
     * @return object staff sims data
     * @throws \Assembly\Client\ApiException
     */
    public function getStaffMembers(){
        $assembly = $this->configureClient();

        return $assembly->getStaffMembers(
            $teachers_only = 'true', $demographics = 'false',
            $qualifications = 'false', $page = null, $per_page = '1500',
            $if_modified_since = null
        )->getData();
    }
}
