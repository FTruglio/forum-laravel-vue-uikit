<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_has_a_profile()
    {
        $user = create('App\User');

        $this->get('/profiles/' . $user->name)
        ->assertSee($user->name);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function profiles_display_all_threads_created_by_associated_user()
    {
        $user = create('App\User');
        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get('/profiles/' . $user->name)
        ->assertSee($thread->title)
        ->assertSee($thread->body);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_user_can_view_a_profile()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
