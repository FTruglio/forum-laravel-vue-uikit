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
    * A basic test example.
    * @test
    * @return void
    */
    public function guest_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }
    
    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function guest_cannot_see_create_threads_page()
    {
        $this->withExceptionHandling()->get('/threads/create')->assertRedirect('/login');
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
        $this->post('/threads', $thread->toArray());
        
        $response = $this->get($thread->path());
        
        $response->assertSee($thread->title)
        ->assertSee($thread->body);
    }
}
