<?php

namespace App;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        if (auth()->guest()) {
            return;
        }
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getActivitiesToRecord()
    {
        return ['created', 'deleted'];
    }

    public function recordActivity($event)
    {
        $this->activity()->create([
          'type' => $this->getActivityType($event),
          'user_id' => auth()->id(),
      ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    public function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return $event . '_' . $type;
    }
}
