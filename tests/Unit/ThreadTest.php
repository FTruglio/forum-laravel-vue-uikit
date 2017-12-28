<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Support\Facades\Notification;

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

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        // Fake the notification
        Notification::fake();

        $this->signIn();
        $userA = auth()->user();
        $userB = create('App\User');

        // Given a user is subscribed to a thread
        $this->thread->subscribe();

        // Reply to the thread
        $this->thread->addReply([
            'body' => 'FooBar',
            'user_id' => $userB->id
        ]);
        // Confirm the notification was sent
        Notification::assertSentTo($userA, ThreadWasUpdated::class);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies()
    {
        $this->signIn();
        $userA = auth()->user();
        $userB = create('App\User');

        // Given a user is subscribed to a thread
        $thread = $this->thread;

        $this->assertTrue($thread->hasUpdatesFor($userA));

        $userA->readThread($thread);

        $this->assertFalse($thread->hasUpdatesFor(auth()->user()));
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_thread_records_each_visit()
    {
        $thread = make('App\Thread', ['id' => 1]);

        $thread->visits()->reset();

        $this->assertSame(0, $thread->visits()->count());

        $thread->visits()->record();
        $this->assertEquals(1, $thread->visits()->count());

        $thread->visits()->record();
        $this->assertEquals(2, $thread->visits()->count());
    }
}
