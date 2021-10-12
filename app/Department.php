<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'department_slug',
    ];

    /**
     * Get the user of the department
     *
     * @return User
     */
    public function user()
    {
        return $this->hasMany('App\User', 'department_slug', 'code');
    }
}
