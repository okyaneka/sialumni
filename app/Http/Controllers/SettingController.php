<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Auth;

class SettingController extends Controller
{
    //
    function get()
    {
    	if (Auth::user()->isAdmin()) {
    		return 'Halo';
    	} else {
    		return view('settings.auth');
    	}
    }

    function set(Request $request)
    {
    	
    }
}
