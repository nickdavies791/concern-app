<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\GetStaffMembers;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_job_gets_dispatched_to_grab_staff_details()
    {
        $this->signIn();

        Queue::fake();

        Queue::assertNothingPushed();

        $this->get('staff/sync')
            ->assertRedirect('settings');

        Queue::assertPushed( GetStaffMembers::class);
    }
}
