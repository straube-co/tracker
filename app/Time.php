<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
        'task_id', 'user_id', 'activity_id', 'started', 'finished',
    ];

    public function task()
    {
        return $this->belongsTo('App\Task');
      }

      public function activity()
      {
          return $this->belongsTo('App\Activity');
        }
}
