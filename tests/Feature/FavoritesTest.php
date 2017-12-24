<?php

namespace Tests\Feature;

use Tests\TestCase;

class FavoritesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function an_unauthenticated_user_can_not_favorite_any_reply()
    {
        $this->withExceptionHandling()
        ->post('replies/1/favorites')
        ->assertRedirect('/login');
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        // if I post to a facvorit endpoint
        $this->post('replies/' . $reply->id . '/favorites');
        // it should be recorded in the database.
        $this->assertCount(1, $reply->favorites);
    }

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function an_authenticated_user_can_unfavorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        // if I post to a facvorit endpoint
        $this->post('replies/' . $reply->id . '/favorites');
        // it should be recorded in the database.
        $this->assertCount(1, $reply->favorites);

        $this->delete('replies/' . $reply->id . '/favorites');
        // Geta fresh instance of reply otherwise it is referencing old data. which will fail the test.
        $this->assertCount(0, $reply->fresh()->favorites);
    }

    /**
     * If multiple requests are posted only 1 should be stored.
     * Add unique() constraints on the database level
     * Add if statment on the PHP level
     * @test
     * @return void
     */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        // if I post twice to the same endpoint
        $this->post('replies/' . $reply->id . '/favorites');
        $this->post('replies/' . $reply->id . '/favorites');
        // it should be recorded in the database.
        $this->assertCount(1, $reply->favorites);
    }
}
