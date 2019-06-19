<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    static function get()
    {
    	$data = [];
    	foreach (Setting::all() as $d) {
    	    $data[$d->name] = $d->config;
    	}
    	return $data;
    }
}
