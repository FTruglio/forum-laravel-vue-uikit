<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->spam = new Spam();
    }
    /**
     * @test
     */
    public function it_checks_for_invalid_keywords()
    {
        // Invalid keywords
        $body = 'Normal reply no spam';

        $reply = $this->spam->detect($body);

        $this->assertFalse($reply);
    }

    /**
     *
     * @test
     * @return void
     */
    public function it_detects_for_any_key_held_down()
    {
        $body = 'Hello world aaaaaaaaaa';

        $this->expectException(\Exception::class);

        $reply = $this->spam->detect($body);

        $this->assertFalse($reply);
    }
}
