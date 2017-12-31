<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadController extends Controller
{
    public function store(Thread $thread)
    {
        if (! auth()->user()->is_admin) {
            return response('You do not have permission to lock this thread', 403);
        }

        $thread->lock();
    }
}
