<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoriteable, RecordActivity;


    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = [ 'favoritesCount', 'isFavorited' ];

    protected static function boot()
    {
        parent::boot();
        // Model events to increment a count
        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });
        // Model events to decrement a count
        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    public function path()
    {
        // link to the thread page and use # to scroll to the reply
        return $this->thread->path() . '#reply-' . $this->id;
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers($reply)
    {
        // Inspect the body of the reply for username mentions
        // preg_match = will only return the first match
        // preg_match_all = will return all matches
        // Create a reg exp https://regexr.com/
        // And then for each mentioned user, notify them
        preg_match_all('/@([\w\-]+)/', $reply->body, $matches);
        return $matches[1];
    }

    public function setBodyAttribute($body)
    {
        // Find the user name and wrap that in an anchor tag.
        // hey @userB
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
       );
    }
}
