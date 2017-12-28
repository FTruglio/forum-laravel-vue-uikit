<?php

namespace Tests\Unit;

use App\Reply;
use Carbon\Carbon;
use Tests\TestCase;

class ReplyTest extends TestCase
{

    /**
    * @test
    * @return void
    */
    public function it_has_an_owner()
    {
        $reply = create('App\Reply');
        $this->assertInstanceOf('App\User', $reply->owner);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_reply_knows_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        // check that it does not trigger the was just published if it was created 1 month ago.
        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /**
     * @test
     */
    public function a_reply_knows_which_users_where_mentioned()
    {
        // Given I have a user whi is signed in User A
        $this->signIn();
        $userA = create('App\User', ['name' => 'userA']);
        // and another user UserB
        $userB = create('App\User', ['name' => 'userB']);

        //if we have a thread
        $thread = create('App\Thread');

        // User A replies and mentions @userB
        $reply = new Reply(
            [
                'user_id' => $userA->id,
                'body' => '@userB look at this'
            ]
        );
        // The reply is posted
        $response = $this->json('POST', $thread->path() . '/replies', $reply->toArray());
        $response->assertStatus(200);

        $this->assertEquals(['userB'], $reply->mentionedUsers($reply));
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        // User A replies and mentions @userB
        $reply = new Reply(
            [
                'body' => 'look at this @userB.'
            ]
        );

        $this->assertEquals(
            'look at this <a href="/profiles/userB">@userB</a>.',
            $reply->body
        );
    }
}
