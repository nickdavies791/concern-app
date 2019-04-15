<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\GetSchoolDetails;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Assembly;

class SchoolControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_job_gets_dispatched_to_grab_school_details()
    {
        $this->signIn();

        Queue::fake();

        Queue::assertNothingPushed();

        $this->get('school/sync')
            ->assertRedirect('settings');

        Queue::assertPushed(GetSchoolDetails::class);
    }
}
