<?php

namespace Tests\Feature;

use Tests\TestCase;

class BestReplyTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thred_creator_may_mark_any_reply_as_the_best_reply()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);

        $this->assertFalse($replies[1]->isBest());

        $this->postJson('replies/'. $replies[1]->id .'/best');

        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function only_the_thread_creator_may_mark_reply_as_best()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $replies = create('App\Reply', ['thread_id' => $thread->id], 2);

        $this->signIn(create('App\User'));

        $response = $this->postJson('replies/'. $replies[1]->id .'/best')
        ->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function if_a_best_reply_is_deleted_then_the_thread_is_updated()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $reply->thread->markBestReply($reply);

        $this->assertTrue($reply->isBest());

        $this->deleteJson(route('replies.destory', $reply));

        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}
