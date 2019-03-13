<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_settings_page_loads_correctly()
    {
        $this->signIn();

        $this->get('settings')->assertOk()
            ->assertViewIs('settings');
    }
    
    /** @test */
    public function a_user_can_search_for_students()
    {
        $this->signIn();

        $student = factory('App\Student')->create();

        $this->post('/search', ['query' => $student->forename])
            ->assertOk()
            ->assertViewIs('search')
            ->assertSee($student->forename);
    }

    /** @test */
    public function a_user_can_search_for_concerns_by_type()
    {
        $this->signIn();
        $concern = factory('App\Concern')->create();

        $this->post('/search', ['query' => $concern->type])
            ->assertOk()
            ->assertViewIs('search')
            ->assertSee($concern->type);
    }

    /** @test */
    public function a_guest_cannot_search_for_anything()
    {
        $student = factory('App\Student')->create();
        $concern = factory('App\Concern')->create();

        $this->post('/search', ['query' => $student->forename])->assertRedirect('login');
        $this->post('/search', ['query' => $concern->type])->assertRedirect('login');
    }
}
