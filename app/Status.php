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
    	'status',
    ];

    /**
     * Get the user of the status
     *
     * @return User
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_statuses', 'status_id', 'user_id')->withPivot('year', 'info');;
    }
}
