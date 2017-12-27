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
}
