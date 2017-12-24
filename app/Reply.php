<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoriteable, RecordActivity;


    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = [ 'favoritesCount', 'isFavorited' ];

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
}
