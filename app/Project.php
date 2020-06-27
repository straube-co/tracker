<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
