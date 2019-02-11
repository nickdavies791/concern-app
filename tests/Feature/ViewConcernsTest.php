<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewConcernsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a user with role 'User' cannot view all concerns
     */
    public function test_role_user_cannot_view_all_concerns()
    {
        // Create the role in the database
        $role = factory(Role::class)->create([
            'type' => 'User',
        ]);
        // Create a user with the role ID attached
        $user = factory(User::class)->create([
            'role_id' => $role->id
        ]);
        // While acting as this user and accessing /concerns URI
        $response = $this->actingAs($user)->get('/concerns');
        // Assert user is redirected and error message is displayed
        $response->assertRedirect('/home');
        $response->assertSessionHas('alert.danger', 'You do not have access to this page.');
    }

    /**
     * Test a user with role 'Staff' cannot view all concerns
     */
    public function test_role_staff_cannot_view_all_concerns()
    {
        // Create the role in the database
        $role = factory(Role::class)->create([
            'type' => 'Staff',
        ]);
        // Create a user with the role ID attached
        $user = factory(User::class)->create([
            'role_id' => $role->id
        ]);
        // While acting as this user and accessing /concerns URI
        $response = $this->actingAs($user)->get('/concerns');
        // Assert user is redirected and error message is displayed
        $response->assertRedirect('/home');
        $response->assertSessionHas('alert.danger', 'You do not have access to this page.');
    }

    /**
     * Test a user with role 'Safeguarding' can view all concerns
     */
    public function test_role_safeguarding_can_view_all_concerns()
    {
        // Create the role in the database
        $role = factory(Role::class)->create([
            'type' => 'Safeguarding',
        ]);
        // Create a user with the role ID attached
        $user = factory(User::class)->create([
            'role_id' => $role->id
        ]);
        // While acting as this user and accessing /concerns URI
        $response = $this->actingAs($user)->get('/concerns');
        // Assert user is directed to /concerns URI
        $response->assertViewIs('concerns.index');
    }

    /**
     * Test a user with role 'Admin' can view all concerns
     */
    public function test_role_admin_can_view_all_concerns()
    {
        // Create the role in the database
        $role = factory(Role::class)->create([
            'type' => 'Admin',
        ]);
        // Create a user with the role ID attached
        $user = factory(User::class)->create([
            'role_id' => $role->id
        ]);
        // While acting as this user and accessing /concerns URI
        $response = $this->actingAs($user)->get('/concerns');
        // Assert user is directed to /concerns URI
        $response->assertViewIs('concerns.index');
    }
}
