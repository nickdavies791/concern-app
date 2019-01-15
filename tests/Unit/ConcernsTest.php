<?php

namespace Tests\Unit;

use App\Concern;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConcernsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a new concern can be created
     */
    public function test_concern_can_be_created()
    {
        // Create user and concern and attach user_id to concern
        $user = factory(User::class)->create();
        factory(Concern::class)->create([
            'user_id' => $user->id,
            'created_at' => Carbon::parse('1st January 2018 11:34:56')
        ]);
        // Assert the database table 'concerns' has the created resource
        $this->assertDatabaseHas('concerns', [
            'user_id' => $user->id,
            'created_at' => '2018-01-01 11:34:56'
        ]);
    }
}
