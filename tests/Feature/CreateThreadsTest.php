<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use App\Rules\Recaptcha;

class CreateThreadsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');

        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
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

        $thread = create('App\Thread', ['title' => 'Foo Title']);

        $this->assertEquals($thread->fresh()->slug, "foo-title");

        $thread =  $this->postJson('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_with_a_title_that_ends_with_a_number_should_generate_a_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Some Title 24']);

        $thread = $this->postJson('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
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

        $response = $this->post('/threads', $thread->toArray() + ['g-recaptcha-response' => 'token']);

        $this->get($response->headers->get('Location'))
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_update_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch($thread->path(), ['title' => 'Changed title', 'body' => 'Changed body']);

        $this->assertEquals('Changed title', $thread->fresh()->title);
        $this->assertEquals('Changed body', $thread->fresh()->body);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_unauthorized_user_can_not_update_a_thread()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => create('App\User')->id]);

        $this->patch(
            $thread->path(),
            ['title' => 'Changed title', 'body' => 'Changed body']
        )->assertStatus(403);
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
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_reqiures_recaptcha_validation()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
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
