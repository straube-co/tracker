<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class Formatter
{

    public static function timeInterval(CarbonInterval $interval)
    {
        return str_pad((int) $interval->totalHours, 2, '0', STR_PAD_LEFT) . ':' . $interval->format('%I');
    }

    public static function timeDiff(Carbon $from, Carbon $to = null)
    {
        if ($to === null) {
            $to = Carbon::now();
        }
        return self::timeInterval($to->diffAsCarbonInterval($from));
    }
}
