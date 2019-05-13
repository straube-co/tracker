<?php

namespace App\Support;

use Carbon\CarbonInterval;

/**
 * Fomatting utility methods.
 *
 * @author Gustavo Straube <gustavo@straube.co>
 */
class Formatter
{

    /**
     * Format the given interval.
     *
     * The returned format is `%H:%I:%S`. In case the interval is equal or
     * greater the one day, the format used is `%d days and %H:%I:%S`.
     *
     * @return string|null
     */
    public static function interval(CarbonInterval $interval = null): ?string
    {
        if ($interval === null) {
            return null;
        }

        $format = $interval->totalDays > 0 ? '%d day(s) and %H:%I:%S' : '%H:%I:%S';
        return $interval->format($format);
    }

    public static function intervalTime(CarbonInterval $interval = null): ?string
    {
        if ($interval === null) {
            return null;
        }
        return str_pad((int)$interval->totalHours, 2, '0', STR_PAD_LEFT ) . ':' . $interval->format('%I:%S');
    }
}
