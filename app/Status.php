<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'code','status',
    ];

    /**
     * Get the user of the status
     *
     * @return User
     */
    public function user()
    {
        return $this->hasMany('App\User','status','code');
    }
}
