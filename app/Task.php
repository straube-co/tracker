<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'id', 'name', 'project_id',
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
