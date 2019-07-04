<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    protected $fillable = [
    	'company',
    	'position',
    	'salary',
    	'location',
    	'email',
    	'phone',
    	'description',
    	'requirements',
        'duedate',
    ];
}
