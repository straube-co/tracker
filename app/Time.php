<?php

namespace App;

use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class Time extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'activity_id',
        'started',
        'finished',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started', 'finished'
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
     * Scope a query to apply reporting filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \ArrayAccess|array $filter
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \RuntimeException
     */
    public function scopeFromReportFilter(Builder $query, $filter)
    {
        if (!(is_array($filter) || $filter instanceof ArrayAccess)) {
            throw new RuntimeException(
                '$filter argument must be an array or an object of a class implementing the ArrayAccess interface.'
            );
        }

        $query->orderBy('started', 'desc');

        if (!empty($filter['activity_id'])) {
            $query->where('activity_id', $filter['activity_id']);
        }

        if (!empty($filter['project_id'])) {
            $project = $filter['project_id'];
            $query->whereHas('task', function ($query) use ($project) {
                $query->where('project_id', $project);
            });
        }

        if (!empty($filter['task_id'])) {
            $query->where('task_id', $filter['task_id']);
        }

        if (!empty($filter['user_id'])) {
            $query->where('user_id', $filter['user_id']);
        }

        if (!empty($filter['started'])) {
            $query->where('started', '>=', $filter['started']);
        }

        if (!empty($filter['finished'])) {
            $query->where('finished', '<=', $filter['finished']);
        }

        return $query;
    }
}
