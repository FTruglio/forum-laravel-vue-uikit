<?php

namespace Tests\Feature;

use App\Trending;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->trending = new Trending();

        $this->trending->reset();
    }
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function it_increments_a_thread_score_each_time_it_is_read()
    {
        $this->assertCount(0, $this->trending->get());

        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $trending = $this->trending->get();

        $this->assertCount(1, $trending);

        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
