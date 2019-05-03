<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'id', 'name',
    ];

    public function getUnfinishedTime(): ?Time
    {
        return Time::whereHas('task', function ($query) {
            $query->where('project_id', $this->id);
        })->where('finished', null)->first();
    }
}
