<?php

namespace Tests\Feature;

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
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }
    
    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect('/login');
        
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
        
        $thread = make('App\Thread');
        
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
        ->assertSessionHasErrors('title');
    }
    
    
    /**
    * validation for threads
    * @test
    * @return void
    */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
        ->assertSessionHasErrors('body');
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
        ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
        ->assertSessionHasErrors('channel_id');
    }
    
    
    public function publishThread($overrides)
    {
        $this->withExceptionHandling()->signIn();
        
        $thread = make('App\Thread', $overrides);
        
        return $this->post('/threads', $thread->toArray());
    }
}