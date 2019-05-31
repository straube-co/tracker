<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function access() {
    //     $access = [];
    //
    //     $query = DB::table('users')->select('access')->get();
    //
    //     // $bin = array_map('intval', explode(',', $query));
    //
    //     $bitmask = strrev(decbin($bin));
    //
    //     for ($i = 0, $s = strlen($bitmask); $i < $s; $i++) {
    //         if ($bitmask{$i}) {
    //             $access[] = pow(2, $i);
    //         }
    //     }
    //
    //     return $access;
    // }
}
