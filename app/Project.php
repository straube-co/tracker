<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

/**
 * Project model.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class Project extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    /**
     * Get the total tracked time for this project.
     *
     * @return \Carbon\CarbonInterval|null
     */
    public function getTrackedTime(): ?CarbonInterval
    {
        $total = DB::select(
            'SELECT SUM(TIME_TO_SEC(TIMEDIFF(finished, started))) AS total
                FROM times INNER JOIN tasks ON times.task_id = tasks.id
                WHERE tasks.project_id = ? AND times.finished IS NOT NULL',
            [ $this->id ]
        )[0]->total;

        if ($total === null) {
            return null;
        }

        return CarbonInterval::seconds((int) $total)->cascade();
    }

    /**
     * Get all the unfinished schedules.
     *
     * @return \Carbon\CarbonInterval|null
     */
    public function getUnfinishedTime(): ?Time
    {
        return Time::where('user_id', Auth::id())->whereHas('task', function ($query) {
            $query->where('project_id', $this->id);
        })->where('finished', null)->first();
    }
}
