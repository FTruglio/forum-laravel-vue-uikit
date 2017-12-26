<?php

namespace App;

class Spam
{
    public function detect($body)
    {
        // Detect invalid keywords.
        $this->detectInvalidKeywods($body);

        return false;
    }

    public function detectInvalidKeywods($body)
    {
        $invalidKeywods = [
            'yahoo customer suppoer'
        ];

        foreach ($invalidKeywods as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('your reply contains spam');
            }
        }
    }
}
