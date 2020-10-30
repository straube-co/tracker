<?php

namespace App\Models;

use App\Support\Formatter;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    use SoftDeletes;

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
        return Formatter::timeInterval($interval);
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
