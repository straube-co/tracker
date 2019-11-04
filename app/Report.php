<?php

namespace App;

use App\Support\Formatter;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Report model.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class Report extends Model
{

    /**
     * The query builder for this report.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    private $results;

    protected $fillable = [
        'id',
        'name',
        'filter',
        'code',
    ];

    protected $casts = [
        'filter' => 'array',
    ];

    /**
     * Get the results query for this report.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getResultsQuery(): Builder
    {
        if (!isset($this->results)) {
            $this->results = Time::fromReportFilter($this->filter);
        }
        return $this->results;
    }

    /**
     * Get the paginated results for this report.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedResults(): LengthAwarePaginator
    {
        return $this->getResultsQuery()->with('user', 'activity', 'task', 'task.project')->paginate();
    }

    /**
     * Get the summary -- a collection of aggregated data - for a query.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSummary(): Collection
    {
        $query = clone $this->getResultsQuery();

        /*
         * TODO: Refactor this to avoid loading the entire query results. Move
         * the calculations to the DB.
         */
        return $query->get()->groupBy('activity_id')->map(function ($times) {
            $now = new Carbon('00:00');
            $start = clone $now;

            return $times->reduce(function ($diff, $time) {
                if ($time->finished !== null) {
                    return $diff->add($time->finished->diff($time->started));
                }
                return $diff;
            }, $now)->diffAsCarbonInterval($start);
        });
    }

    /**
     * Build a CSV file (contents only) based on the report results.
     *
     * @return string
     */
    public function getResultsAsCsvString(): string
    {
        $times = $this->getResultsQuery()->with('user', 'activity', 'task', 'task.project')->get();

        $rows = [
            [
                'Project',
                'Task',
                'Activity',
                'User',
                'Started',
                'Finished',
                'Ellapsed time',
            ]
        ];

        foreach ($times as $time) {
            $ellapsed = null;
            if ($time->finished) {
                $ellapsed = Formatter::intervalTime(
                    $time->finished->diffAsCarbonInterval($time->started)
                );
            }
            $rows[] = [
                $time->task->project->name,
                $time->task->name,
                $time->activity->name,
                $time->user->name,
                $time->started,
                $time->finished,
                $ellapsed,
            ];
        }

        $rows = array_map(function ($row) {
            return '"' . implode('","', $row) . '"';
        }, $rows);

        return implode("\n", $rows);
    }
}
