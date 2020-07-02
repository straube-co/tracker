<?php

namespace App;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Project model.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function getTrackedTime(): ?string
    {
        if (!$this->tracked_seconds) {
            return null;
        }

        $interval = CarbonInterval::seconds((int) $this->tracked_seconds)->cascade();
        return str_pad((int) $interval->totalHours, 2, '0', STR_PAD_LEFT) . ':' . $interval->format('%I:%S');
    }

    public function scopeSelectTrackedTime(Builder $query): Builder
    {
        $query->select('projects.*')->selectSub(
            Time::select(DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(times.finished, times.started)))'))
                ->where('times.project_id', DB::raw('projects.id'))
                ->groupBy('times.project_id'),
            'tracked_seconds'
        );

        return $query;
    }
}
