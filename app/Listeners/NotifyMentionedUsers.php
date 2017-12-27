<?php

namespace App\Listeners;

use App\User;
use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        // Inspect the body of the reply for username mentions
        // preg_match = will only return the first match
        // preg_match_all = will return all matches
        // Create a reg exp https://regexr.com/
        // And then for each mentioned user, notify them
        collect($event->reply->mentionedUsers($event->reply))
        ->map(function ($name) {
            return User::whereName($name)->first();
            // If filter with no arguments, it will strip app NULL values
        })
        ->filter()
        ->each(function ($user) use ($event) {
            $user->notify(new YouWereMentioned($event->reply));
        });
    }
}
