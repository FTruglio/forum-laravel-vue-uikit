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

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = make(
            'App\Reply',
            [
                'body' => '@JaneDoe look at this'
            ]
        );

        $this->assertEquals(['JaneDoe'], $reply->mentionedUsers($reply));
    }

    /**
     * @test
     */
    public function it_wraps_mentioned_usernames_in_the_body_withing_anchor_tags()
    {
        $reply = make(
            'App\Reply',
            [
                'body' => 'Hello @JaneDoe.'
            ]
        );

        $this->assertEquals(
            'Hello <a href="/profiles/JaneDoe">@JaneDoe</a>.',
            $reply->body
        );
    }
}
