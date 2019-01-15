<?php

namespace Tests\Unit;

use App\Comment;
use App\Concern;
use App\Group;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a comment can be created
     */
    public function test_a_comment_can_be_created()
    {
        $user = factory(User::class)->create();
        $concern = factory(Concern::class)->create([
            'user_id' => $user->id,
        ]);
        factory(Comment::class)->create([
            'user_id' => $user->id,
            'concern_id' => $concern->id
        ]);
        $this->assertDatabaseHas('comments', ['user_id' => $user->id]);
    }
}
