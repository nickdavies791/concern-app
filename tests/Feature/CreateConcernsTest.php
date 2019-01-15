<?php

namespace Tests\Feature;

use App\Concern;
use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateConcernsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a new concern can be created
     */
    public function test_concern_can_be_created()
    {
        // Create the role in the database
        $role = factory(Role::class)->create(['type' => 'Admin']);
        // Create a user with the role ID attached
        $user = factory(User::class)->create(['role_id' => $role->id]);
        // Create fake concern with above user
        $concern = factory(Concern::class)->raw([
            'user_id' => $user->id,
            'concern_date' => '15 June 2018 11:35am'
        ]);
        // Post the concern data to the concerns.store route
        $response = $this->actingAs($user)->post(route('concerns.store'), $concern);
        // Make assertions to ensure everything is working properly
        $response->assertRedirect('/concerns/1');
        $this->assertDatabaseHas('concerns', [
            'user_id' => $user->id,
            'concern_date' => '2018-06-15 11:35:00'
        ]);
    }
}
