<?php

namespace App\Http\Controllers\Api;

use App\Point;
use App\Http\Controllers\Controller;

/**
 * Schedules controller.
 *
 *
 * @author Lucas Cardoso <lucas@straube.co>
 *
 */
class SchedulesController extends Controller
{
    public function index(string $date_entry, int $user_id)
    {
        $points = Point::where('entry', '<=', $date_entry)->where('user_id', $user_id)->get();
        
        return $points;
    }
}
