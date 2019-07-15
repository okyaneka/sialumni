<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    static function get($key = '')
    {
    	$data = [];
    	foreach (Setting::all() as $d) {
    	    $data[$d->name] = $d->config;
    	}

    	if (!empty($key)) {
    		return $data[$key];
    	}

    	return $data;
    }
}
