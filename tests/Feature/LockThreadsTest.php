<?php

namespace Tests\Feature;

use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function non_admins_may_not_lock_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        // Hit end point that will update the locked attribute to TRUE for the thread.
        $this->post(route('locked-threads.store', $thread))->assertStatus(302);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function admins_may_lock_threads()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        // Hit end point that will update the locked attribute to TRUE for the thread.
        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue(!! $thread->fresh()->locked);
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $thread->lock();

        $this->assertTrue($thread->locked);

        // If we hit the endpoint to hit the reply if the thread is locked it should not work.
        $this->post($thread->path() . '/replies', [
            'body' => 'Foobar',
            'user_id' => create('App\User')->id
        ])->assertStatus(422);
    }
}
