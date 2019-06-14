<?php

namespace App;

use App\Time;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'id', 'name',
    ];

    public function times()
    {
        return $this->hasMany('App\Time');
    }

    public function activityUsed()
    {
        return $this->times()->count() > 0;
    }
}
