<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReadThreadsTest extends TestCase
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
    public function a_user_can_read_all_threads()
    {
        $response = $this->get('/threads')
        ->assertSee($this->thread->title);
    }
    
    /**
    * @test
    * @return void
    */
    public function a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path())
        ->assertSee($this->thread->title);
    }
    
    /**
    * @test
    * @return void
    */
    public function a_user_can_read_replies_that_are_associated_With_a_thread()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);
        
        $response = $this->get($this->thread->path())
        ->assertSee($reply->body);
    }
    
    /**
    *
    * @test
    * @return void
    */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        
        $this->get('/threads/' . $channel->slug)
        ->assertSee($threadInChannel->title)
        ->assertDontSee($threadNotInChannel->title);
    }
    
    /**
    * filtering threads by username
    * @test
    * @return void
    */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'johnDoe']));
        
        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        
        $this->get('/threads?by=johnDoe')
        ->assertSee($threadByJohn->title)
        ->assertDontSee($threadNotByJohn->title);
    }

    /**
    *  Filtering threads by popularity
    * @test
    * @return void
    */
    public function a_user_can_filter_threads_by_popularity()
    {
        // given we have threads
        // with 2 relipes, 3 replies, 0 replies respectively
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        // when I filter threads by popularity
        $response = $this->getJson('threads?popular=1')->json();
        // then they should be returned in descending order from most to least
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
