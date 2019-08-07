<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Time extends Model
{
    protected $fillable = [
        'task_id', 'user_id', 'activity_id', 'started', 'finished',
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        'task',
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
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReportFromRequest(Builder $query, Request $request)
    {
        $query->select('times.*')->orderBy('started', 'desc');

        if (($activity = $request->activity_id)) {
            $query->where('activity_id', $activity);
        }
        if (($project = $request->project_id)) {
            $query->whereHas('task', function ($query) use ($project) {

                $query->where('project_id', $project);
            });
        }
        if (($task = $request->task_id)) {
            $query->where('task_id', $task);
        }
        if (($user = $request->user_id)) {
            $query->where('user_id', $user);
        }
        if (($started = $request->started)) {
            $query->where('started', '>=', $started);
        }
        if (($finished = $request->finished)) {
            $query->where('finished', '<=', $finished);
        }

        return $query;
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
