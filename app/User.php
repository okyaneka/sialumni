<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isDataComplete()
    {
        foreach ($this->fillable as $column) {
            if(empty($this->$column)) return FALSE;
        }
        return TRUE;
    }

    /**
     * Get the department for the user.
     *
     * @return Department
     */
    public function department()
    {
        return $this->hasOne('App\Department','code','department');
    }

    /**
     * Get the status for the user.
     *
     * @return Status
     */
    public function status()
    {
        return $this->hasOne('App\Status','code','status');
    }

    /**
     * Get the status for the user.
     *
     * @return Group
     */
    public function group()
    {
        return $this->hasOne('App\Group','grad','grad');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'pob', 'dob', 'street', 'address', 'sub_district', 'district', 'department', 'status', 'grad', 'phone', 'telegram',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
