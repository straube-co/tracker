<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User Model.
 *
 * @version 1.0.0
 * @author Lucas Cardoso <lucas@straube.co>
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
    * Default type of permissions.
    *
    * @var int
    */
    const DEFAULT_PERMISSION = 0;

    /**
    * Type of permissions.
    *
    * @var int
    */
    const SETTINGS_PERMISSION = 1;

    /**
    * Type of permissions
    *
    * @var int
    */
    const REPORTS_PERMISSION = 2;

    /**
    * Type of permissions
    *
    * @var int
    */
    const ADMIN_PERMISSION = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'access',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $rememberTokenName = false;

    /**
    *
    *
    * @return
    */
    public function getPermissionsName()
    {
        $permission = self::getPermissions();
        return $permission[$this->permission] ?? null;
    }

    /**
    * Get all available type of clients.
    *
    * @return string[]
    */
    public static function getPermissions(): array
    {
        return [
            self::SETTINGS_PERMISSION => 'Settings',
            self::REPORTS_PERMISSION => 'Reports',
            self::ADMIN_PERMISSION => 'Admin',
        ];
    }

    /**
     * Determine access.
     *
     * @var array
     */
    public function access()
    {
        $access = [];

        $bitmask = strrev(decbin($this->access));

        for ($i = 0, $s = strlen($bitmask); $i < $s; $i++) {
            if ($bitmask{$i}) {
                $access[] = pow(2, $i);
            }
        }

        return $access;
    }
}
