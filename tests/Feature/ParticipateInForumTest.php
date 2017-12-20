<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipateInForum extends TestCase
{
    
    /**
    * A basic test example.
    * @test
    * @return void
    */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        $this->post('/threads/1/replies', []);
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
}
