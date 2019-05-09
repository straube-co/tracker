<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    protected $fillable = [
        'id', 'name',
    ];

    public function projectTimes(): ? CarbonInterval
    {
        $carbon = DB::select('select
                                sec_to_time(sum(time_to_sec(timediff(finished, started)))) as total
                                FROM times INNER JOIN tasks ON times.task_id = tasks.id where tasks.project_id = ? and times.finished is not NULL', [$this->id]) [0]->total;

        if($carbon == null ) {
            return null;
        }
        list($hours, $minutes, $seconds) = sscanf($carbon, '%d:%d:%d');
        return CarbonInterval::create(sprintf('PT%dH%dM%dS', $hours, $minutes, $seconds));

    }

    public function getUnfinishedTime(): ?Time
    {
        return Time::where('user_id', session()->get('auth.id'))->whereHas('task', function ($query) {
            $query->where('project_id', $this->id);
        })->where('finished', null)->first();
    }
}
