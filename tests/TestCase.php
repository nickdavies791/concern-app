<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user=null){ 
        $user = $user ? $user : factory('App\User')->create();
        return $this->actingAs($user);
    }
}
