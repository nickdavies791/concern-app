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
        $this->withoutExceptionHandling();
        $role = factory(Role::class)->create(['type' => 'Admin']);
        $user = factory(User::class)->create(['role_id' => $role->id]);
        $concern = factory(Concern::class)->raw([
            'user_id' => $user->id,
            'type' => 'Observation',
            'concern_date' => '15 June 2018 11:35am'
        ]);

        $response = $this->actingAs($user)->post(route('concerns.store'), $concern);

        $response->assertRedirect('/concerns/1');
        $this->assertDatabaseHas('concerns', [
            'user_id' => $user->id,
            'type' => 'Observation',
            'concern_date' => '2018-06-15 11:35:00'
        ]);
    }
}
