<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Jobs\GetStudents;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
       Parent::setUp();

        $this->user = factory('App\User')->create();
        $this->student = factory('App\Student')->create();
        $this->concern = factory('App\Concern')->create(['user_id' => $this->user->id]);
        $this->attendance = factory('App\Attendance')->create(['student_id' => $this->student->id]);
        $this->exclusion = factory('App\Exclusion')->create(['student_id' => $this->student->id]);
    }

    /** @test */
    public function the_data_for_the_multi_select_is_returned()
    {
        $this->signIn();

        $this->get('students')
            ->assertSee($this->student->id)
            ->assertSee($this->student->mis_id)
            ->assertSee($this->student->admission_number)
            ->assertSee($this->student->forename)
            ->assertSee($this->student->surname)
            ->assertSee($this->student->year_group);
    }
    
    

    /** @test */
    public function a_user_can_view_a_students_details()
    {
        $this->signIn($this->user);
        $this->get("students/{$this->student->id}")
            ->assertSee($this->student->full_name)
            ->assertSee($this->student->year_group)
            ->assertSee($this->student->sen_category);
    }

    /** @test */
    public function a_user_can_view_a_students_exclusions_details()
    {   
        $this->signIn($this->user);
        $this->get("students/{$this->student->id}")
            ->assertSee($this->student->exclusions->first()->type)
            ->assertSee($this->student->exclusions->first()->reason)
            ->assertSee($this->student->exclusions->first()->start_date)
            ->assertSee($this->student->exclusions->first()->end_date)
            ->assertSee($this->student->exclusions->first()->length);
    }

    /** @test */
    public function a_user_can_view_a_students_attendance_details()
    {
        $this->signIn($this->user);
        $this->get("students/{$this->student->id}")
            ->assertSee($this->student->attendance->start_date)
            ->assertSee($this->student->attendance->end_date);
      
    }
    
    /** @test */
    public function the_job_gets_dispatched_to_grab_students_details()
    {
        $this->signIn();

        Queue::fake();

        Queue::assertNothingPushed();

        $this->get('students/sync')
            ->assertRedirect('settings');

        Queue::assertPushed(GetStudents::class);
    }
}
