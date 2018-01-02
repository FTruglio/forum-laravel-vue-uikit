<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;

class SearchTest extends TestCase
{

    /**
     * Searching threads
     * @test
     * @return void
     */
    public function a_user_can_search_threads()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "A thread with the {$search} term"], 2);

        // To account for network latency issues
        do {
            sleep(.25);

            $results = $this->getJson("/threads/search/?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
