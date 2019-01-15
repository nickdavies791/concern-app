<?php

namespace Tests\Unit;

use App\Concern;
use App\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConcernTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a concern can be created
     */
    public function test_a_concern_can_be_created()
    {
        $user = factory(User::class)->create();
        factory(Concern::class)->create([
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('concerns', ['user_id' => $user->id]);
    }


}
