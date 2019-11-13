<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Point extends Model
{
    /**
    * Minutes of total hours worked on the day.
    *
    * @var int
    */
    const MINUTES = 420;

    protected $fillable = [
        'user_id',
        'started',
        'finished',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started',
        'finished',
    ];

    /*
    * The relationship with User.
    *
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
    * Function to check if there is a null output.
    *
    * @return boolean
    */
    public static function exit()
    {
        return self::where('user_id', Auth::id())->where('finished', null)->count() < 1;
    }

    /**
    * Function for convert minutes in hours.
    *
    * @param string $dateTime
    * @return string
    */
    public static function convertToHours($dateTime)
    {
        return str_pad(intval($dateTime / 60), 2, '0', STR_PAD_LEFT) . ':' .
            str_pad($dateTime % 60, 2, '0', STR_PAD_RIGHT);
    }

    /**
    * Function to calculate extra hours.
    *
    * @param string $dateTime
    * @return string
    */
    public static function extra($dateTime)
    {
        if ($dateTime > self::MINUTES) {
            return self::convertToHours($dateTime - self::MINUTES);
        }
        return '- -';
    }
}
