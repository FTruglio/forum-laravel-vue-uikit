<?php

namespace Tests\Unit;

use Tests\TestCase;

class ThreadTest extends TestCase
{
    protected $thread;
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }
    /**
    * @test
    * @return void
    */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /**
    * @test
    * @return void
    */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /**
    * @test
    * @return void
    */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([

            'body' => 'FooBar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /**
    * A thread belongs to a channel
    * @test
    * @return void
    */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_can_be_subscribed_to()
    {
        // Given we havea. thread

        $thread = create('App\Thread');

        // When the user subscribes to the thread

        $thread->subscribe($userId = 1);

        // Then we should be able to fetch all threads that the user subscribed to.

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_can_be_unsubscribed_from()
    {
        // Given we havea. thread

        $thread = create('App\Thread');

        // When the user subscribes to the thread

        $thread->unsubscribe($userId = 1);

        // Then we should be able to fetch all threads that the user subscribed to.

        $this->assertEquals(0, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_knows_if_an_authenticated_user_is_subscribed_to_it()
    {
        $this->signIn();
        // Given we havea. thread

        $thread = create('App\Thread');

        // When the user subscribes to the thread

        // Check that it is false
        $this->assertFalse($thread->isSubscribedTo);

        // Subscribe to the thread
        $thread->subscribe();

        // Check that it is true
        $this->assertTrue($thread->isSubscribedTo);
    }
}
