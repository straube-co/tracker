<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Activity model.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class Activity extends Model
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
