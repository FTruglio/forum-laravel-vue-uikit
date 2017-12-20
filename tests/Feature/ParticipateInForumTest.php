<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;
    
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
        $this->be($user = factory('App\User')->create());
        
        $thread = factory('App\Thread')->create();
        
        $reply = factory('App\Reply')->make();
        $this->post($thread->path() . '/replies', $reply->toArray());
        
        $this->get($thread->path())
        ->assertSee($reply->body);
    }
}
