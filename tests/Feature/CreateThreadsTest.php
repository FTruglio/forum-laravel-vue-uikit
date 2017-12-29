<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }
    /**
    * @test
    * @return void
    */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->slug}", $thread->path());
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Foo Title', 'slug' => 'foo-title']);

        $this->assertEquals($thread->fresh()->slug, "foo-title");
        // Options to persist uniquene slugs:
        // foo-title-123434
        // foo-title-timestamp
        // foo-title-2
        // foo-title-3

        $this->post('/threads', $thread->toArray());

        $this->assertTrue(Thread::whereSlug('foo-title-2')->exists());
    }

    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')
        ->assertRedirect('/login');

        $this->withExceptionHandling()
        ->post('/threads')
        ->assertRedirect('/login');
    }


    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread', ['user_id' => auth()->id()]);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }

    /**
    * validation for threads
    * @test
    * @return void
    */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
        ->assertStatus(422);
    }


    /**
    * validation for threads
    * @test
    * @return void
    */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
        ->assertStatus(422);
    }


    /**
    * validation for threads
    * @test
    * @return void
    */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
        ->assertStatus(422);

        $this->publishThread(['channel_id' => 999])
        ->assertStatus(422);
    }


    public function publishThread($overrides)
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function unauthorized_users_cannot_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');
        $this->delete($thread->path())->assertRedirect('/login');

        // A user without permission cannot delete a thread
        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function authorized_user_can_delete_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', [ 'user_id' => auth()->id() ]);
        $reply = create('App\Reply', [ 'thread_id' => $thread->id ]);

        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $thread->id,
            'type' => 'created_thread',
            'subject_type' => get_class($thread)
        ]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->id,
            'type' => 'created_reply',
            'subject_type' => get_class($reply)
        ]);
    }

    /**
     * User email confirmation
     * @test
     * @return void
     */
    public function authenticated_users_must_first_confirm_email_address_before_submitting_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();

        $this->withExceptionHandling()->signIn($user);

        $thread = make('App\Thread');

        return $this->post('/threads', $thread->toArray())
        ->assertRedirect('/threads')
        ->assertSessionHas('flash', 'You must first confirm your email address');
    }
}
