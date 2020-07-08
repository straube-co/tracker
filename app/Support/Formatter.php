<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterval;

class Formatter
{

    public static function timeInterval(CarbonInterval $interval, bool $seconds = false)
    {
        $format = '%I';
        if ($seconds) {
            $format .= ':%S';
        }
        return str_pad((int) $interval->totalHours, 2, '0', STR_PAD_LEFT) . ':' . $interval->format($format);
    }

    public static function timeDiff(Carbon $from, Carbon $to = null, bool $seconds = false)
    {
        if ($to === null) {
            $to = Carbon::now();
        }
        return self::timeInterval($to->diffAsCarbonInterval($from), $seconds);
    }
}
