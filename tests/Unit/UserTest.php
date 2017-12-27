<?php

namespace Tests\Unit;

use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_fetch_most_recent_reply()
    {
        $userA = create('App\User');

        $reply = create('App\Reply', ['user_id' => $userA->id]);

        // compare that the reply id matches the users last reply id.
        $this->assertEquals($reply->id, $userA->lastReply->id);
    }
}
