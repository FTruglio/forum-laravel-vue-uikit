<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        // Returns the appropriate relationship for the activity.
        return $this->morphTo();
    }
}
