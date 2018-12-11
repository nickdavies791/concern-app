<?php

namespace App\Repositories;

use App\Token;
use GuzzleHttp\Client;
use Assembly\Client\Configuration;
use Assembly\Client\Api\AssemblyApi;

class Assembly {

    /**
     * Gets the Oauth details from the Assembly api
     * @param  string $code authorisation code
     * @return object Oauth token details
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
     * refreshes access token in database
     * @param  App\Token  $token
     * @return boolean Success of refresh token
     */
    protected function refreshToken(Token $token){
        $response = (new Client())->post('https://platform.assembly.education/oauth/token', [
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
     * configures the assembly api client
     * @return Assembly\Client\Api\AssemblyApi Instance of Assembly API Client
     */
    protected function configureClient(){
        $token = Token::first();

        if($token->expires_in){
            $this->refreshToken($token);
        }

        $config = Configuration::getDefaultConfiguration()
            ->setAccessToken($token->secret);

        return new AssemblyApi(new Client(), $config);
    }

    /**
     * gets the student data from sims for all students
     * @return object student sims data
     */
    public function getStudents(){
        $assembly = $this->configureClient();

        return $assembly->getStudents(
            $year_code = null, $students = null, $date = null, $demographics = 'false',
            $contacts = 'false', $sen_needs = 'false', $addresses = 'false', $care = 'false',
            $languages = 'false', $page = '1', $per_page = '1500', $if_modified_since = null
        )->getData();
    }

    /**
     * gets the staff data from sims for teaching staff
     * @return object staff sims data
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
