<?php

namespace App\Repositories;

use App\Token;
use GuzzleHttp\Client;
use Assembly\Client\Configuration;
use Assembly\Client\Api\AssemblyApi;

class Assembly {

    /**
     * configures the assembly api client
     * @return Assembly\Client\Api\AssemblyApi Instance of Assembly API Client
     */
    protected function configureClient(){
        $token = Token::first();

        if($token->expires_in){
            $token->refresh();
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

    public function getStaffMembers(){
        $assembly = $this->configureClient();

        return $assembly->getStaffMembers(
            $teachers_only = 'true', $demographics = 'false',
            $qualifications = 'false', $page = null, $per_page = '1500',
            $if_modified_since = null
        )->getData();
    }
}
