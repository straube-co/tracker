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
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'started', 'finished'
    ];
}
