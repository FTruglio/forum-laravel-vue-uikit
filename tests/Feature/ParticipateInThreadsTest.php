<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipateInThreads extends TestCase
{
    
    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
        ->post('/threads/some-channel/1/replies', [])
        ->assertRedirect('/login');
    }
    
    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function an_authenticated_user_can_participate_in_forum_threads()
    {
        $this->be($user = create('App\User'));
        
        $thread = create('App\Thread');
        $reply = make('App\Reply');
        
        $this->post($thread->path() . '/replies', $reply->toArray());
        
        $this->get($thread->path())
        ->assertSee($reply->body);
    }
    
    /**
    * validation
    * @test
    * @return void
    */
    public function a_reply_requires_a_body()
    {   
        $this->withExceptionHandling()->signIn();
        
        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);
        
        $this->post($thread->path() . '/replies', $reply->toArray())
        ->assertSessionHasErrors('body');
    }
}
