<?php

namespace App\Models;

use App\Support\Formatter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Time model.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class Time extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'activity_id',
        'description',
        'started',
        'finished',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started',
        'finished',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function getTrackedTime(): ?string
    {
        if (!$this->finished || !$this->started) {
            return null;
        }

        return config('settings.time_decimal', false) ? Formatter::decimalIntervalFromDates($this->started, $this->finished) : Formatter::intervalFromDates($this->started, $this->finished);
    }

    /**
     * Scope a query to apply reporting filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \App\Models\Report $report
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \RuntimeException
     */
    public function scopeFromReport(Builder $query, Report $report): Builder
    {
        $filter = $report->filter;

        $query->orderBy('started', 'desc');

        if (!empty($filter['activity_id'])) {
            $query->where('activity_id', $filter['activity_id']);
        }

        if (!empty($filter['project_id'])) {
            $query->where('project_id', $filter['project_id']);
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

    public function scopeSelectActivityTotals(Builder $query): Builder
    {
        return $query->select([
            'activities.id',
            'activities.name',
            DB::raw('SUM(TIMESTAMPDIFF(SECOND, times.started, IFNULL(times.finished, CURRENT_TIMESTAMP))) AS total'),
        ])
            ->join('activities', 'times.activity_id', '=', 'activities.id')
            ->groupBy('activities.id', 'activities.name');
    }
}
