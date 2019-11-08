<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Point extends Model
{
    protected $fillable = [
        'user_id',
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

    /*
    *
    *
    */
   public static function exit()
   {
       return self::where('user_id', Auth::id())->where('finished', null)->count() < 1;
   }
}
