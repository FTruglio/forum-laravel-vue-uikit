<?php

namespace Tests\Feature;

use Tests\TestCase;

class ChannelTest extends TestCase
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
    public function a_channel_consists_of_threads()
    {
        $channel = create('App\Channel');

        $thread = create('App\Thread', ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
