<?php

namespace App\Inspections;

class KeyHeldDown
{

    /**
    * @param  string $body
    * @return Exception
    */
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('your reply contains spam');
        }
    }
}
