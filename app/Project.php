<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

/**
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Project extends Model
{
    protected $fillable = [
        'id', 'name',
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

    public function getUnfinishedTime(): ?Time
    {
        return Time::where('user_id', session()->get('auth.id'))->whereHas('task', function ($query) {
            $query->where('project_id', $this->id);
        })->where('finished', null)->first();
    }
}
