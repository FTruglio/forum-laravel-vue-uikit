<?php

namespace Tests\Unit;

use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /**
     * @test
     */
    public function it_validates_spam()
    {
        //
        $spam = new Spam();
        $body = 'Normal reply no spam';

        $reply = $spam->detect($body);

        $this->assertFalse($reply);
    }
}
