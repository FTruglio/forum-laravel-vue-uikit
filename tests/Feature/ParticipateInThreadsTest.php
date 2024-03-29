<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipateInThreads extends TestCase
{

    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
        ->post('/threads/some-channel/1/replies', [])
        ->assertRedirect('/login');
    }

    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function an_authenticated_user_can_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /**
    * validation
    * @test
    * @return void
    */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertStatus(422);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete('/replies/' . $reply->id)
        ->assertRedirect('/login');
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function an_authorized_user_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->json('DELETE', '/replies/' . $reply->id);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function authorized_users_can_udpate_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updatedReply = 'updated this reply';
        $this->patch('/replies/' . $reply->id, ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'body' => $updatedReply
        ]);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch('/replies/' . $reply->id)
        ->assertRedirect('/login');
    }

    /**
     * detecting spam in thread replies
     * @test
     * @return void
     */
    public function replies_that_contain_spam_may_not_be_created()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'yahoo customer support'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())->assertStatus(422);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_reply_maximum_once_per_minute()
    {
        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'My simple reply'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertStatus(200);

        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertStatus(429);
    }
}
