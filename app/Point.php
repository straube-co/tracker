<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Point extends Model
{
    protected $fillable = [
        'user_id',
        'entry',
        'exit',
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
       return self::where('user_id', Auth::id())->where('exit', null)->count() < 1;
   }
}
