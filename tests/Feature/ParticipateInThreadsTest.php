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
        $this->be($user = create('App\User'));

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
        ->assertSee($reply->body);
    }

    /**
    * validation
    * @test
    * @return void
    */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertSessionHasErrors('body');
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
}
