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
        $id = $this->id;

        return Time::whereHas('task', function ($query) use ($id) {

          $query->where('project_id', $id);

        })->where('finished', NULL)->first();
    }
}
