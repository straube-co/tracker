<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Report model.
 *
 * @version 2.0.0
 * @author  Lucas Cardoso <lucas@straube.co>
 * @author  Gustavo Straube <gustavo@straube.co>
 */
class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'filter',
        'code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'filter' => 'array',
    ];

    /**
     * Get the default report for a given user.
     *
     * @param  \App\User $user
     * @return \App\Report
     */
    public static function getDefaultReport(User $user): Report
    {
        $now = Carbon::now();
        $filter = [
            'started' => $now->copy()->startOfWeek(),
            'end' => $now->copy()->endOfWeek(),
            'user_id' => $user->id,
            'project_id' => null,
            'activity_id' => null,
        ];
        return new self([
            'name' => __('My week'),
            'filter' => $filter,
        ]);
    }

}
