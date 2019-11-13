<?php

namespace App;

use App\Time;
use Illuminate\Database\Eloquent\Model;

/**
 * Activity model.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class Activity extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    /*
    * The relationship with Time.
    *
    */
    public function times()
    {
        return $this->hasMany('App\Time');
    }

    /**
     * Checks if activity is used.
     *
     * @return boolean
     */
    public function activityUsed()
    {
        return $this->times()->count() > 0;
    }
}
