<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'grad','link',
    ];

    /**
     * Get the user of the group
     *
     * @return User
     */
    public function user()
    {
        return $this->hasMany('App\User','grad','grad');
    }
}
