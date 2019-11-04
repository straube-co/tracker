<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Task Model.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'project_id',
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = [
        'project',
    ];

    /*
    * The relationship with Project.
    *
    */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
