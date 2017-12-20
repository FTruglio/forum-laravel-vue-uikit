<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }
    /**
     * @test
     * @return void
     */
    public function a_user_can_view_all_threads()
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
        $reply = factory('App\Reply')
        ->create(['thread_id' => $this->thread->id]);
        
        $response = $this->get($this->thread->path())
        ->assertSee($reply->body);
    }
}
