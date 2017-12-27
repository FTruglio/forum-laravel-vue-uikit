<?php

namespace Tests\Feature;

use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function mentioned_users_in_a_reply_are_notified()
    {
        // Given I have a user whi is signed in User A
        $this->signIn();
        $userA = create('App\User', ['name' => 'userA']);
        // and another user UserB
        $userB = create('App\User', ['name' => 'userB']);

        //if we have a thread
        $thread = create('App\Thread');

        // User A replies and mentions @userB
        $reply = make(
            'App\Reply',
            [
                'user_id' => $userA->id,
                'body' => '@userB look at this'
            ]
        );
        // The reply is posted
        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(200);

        // UserB should be notified
        $this->assertCount(1, $userB->notifications);
    }
}
