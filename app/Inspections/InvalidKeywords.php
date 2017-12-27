<?php

namespace App\Inspections;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support'
    ];

    /**
     * @param  string $body
     * @return Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('your reply contains spam');
            }
        }
    }
}
