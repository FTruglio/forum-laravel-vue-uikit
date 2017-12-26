<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->signIn();

        $this->userA = auth()->user();
        $this->userB = create('App\User');
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_notification_is_prepared_when_a_subscribed_thread_recieves_a_reply_that_is_not_by_the_current_user()
    {
        $thread = create('App\Thread')->subscribe();

        // Before a reply there are no notificatoins
        $this->assertCount(0, $this->userA->notifications);

        // Then each time a reply is left
        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply'
        ]);

        // Assert that a notification is prepared for the user
        $this->assertCount(0, $this->userA->fresh()->notifications);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_notification_is_prepared_for_a_reply_not_created_by_the_user_who_created_the_reply()
    {
        $thread = create('App\Thread')->subscribe();

        // Before a reply there are no notificatoins
        $this->assertCount(0, $this->userA->notifications);

        // Then each time a reply is left
        $thread->addReply([
            'user_id' => $this->userB->id,
            'body' => 'Some reply'
        ]);
        // Before a reply there are no notificatoins
        $this->assertCount(1, $this->userA->fresh()->notifications);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_fetch_their_unreadNotifications()
    {
        create(DatabaseNotification::class);

        $response = $this->getJson('/profiles/' . $this->userA->name . '/notifications')->json();

        $this->assertCount(1, $response);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        $this->assertCount(1, $this->userA->unreadNotifications);

        $notificationId = $this->userA->unreadNotifications->first()->id;

        $this->delete('/profiles/' . $this->userA->name . '/notifications/' . $notificationId);

        $this->assertCount(0, $this->userA->fresh()->unreadNotifications);
    }
}
