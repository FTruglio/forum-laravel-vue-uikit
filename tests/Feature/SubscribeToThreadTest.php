<?php

namespace Tests\Feature;

use Tests\TestCase;

class SubscribeToThreadTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_subscribe_to_a_thread()
    {
        $this->signIn();
        // given we have a thread
        $thread = create('App\Thread');

        // A user clicks a button to subscribe to the thread
        $this->post($thread->path() . '/subscribtions');

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_unsubscribe_from_a_thread()
    {
        $this->signIn();
        // given we have a thread
        $thread = create('App\Thread');

        $thread->subscribe();

        // A user clicks a button to unsubscribe from the thread
        $this->delete($thread->path() . '/subscribtions');

        // Assert that a notification is prepared for the user
        $this->assertCount(0, $thread->subscriptions);
    }
}
