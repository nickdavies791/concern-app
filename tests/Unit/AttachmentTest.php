<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttachmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_attachment_belongs_to_a_concern()
    {
        $concern = factory('App\Concern')->create();
        $attachment = factory('App\Attachment')->create([
            'concern_id' => $concern->id
        ]);

        $differentAttachment = factory('App\Attachment')->create();

        $this->assertEquals($concern->id, $attachment->concern->id);
        $this->assertNotEquals($concern->id, $differentAttachment->concern->id);
    }
}
