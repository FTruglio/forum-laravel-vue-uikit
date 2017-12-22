<?php

namespace Tests\Unit;

use App\Activity;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    /**
    * @test
    * @return void
    */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        // A reply creates a thread
        $reply = create('App\Reply');

        // We now expect two activities (1 for the reply, 1 for the thread).
        $this->assertEquals(2, Activity::count());
    }
}
