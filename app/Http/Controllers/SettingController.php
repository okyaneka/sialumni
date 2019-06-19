<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Auth;
use DB;

class SettingController extends Controller
{
    //
    function get()
    {
    	if (Auth::user()->isAdmin()) {
            $data = Setting::get();

    		return view('settings.admin', $data);
    	} else {
    		return view('settings.auth');
    	}
    }

    function set(Request $request)
    {
    	$request->validate([
            'defaultpassword' => 'required|min:6',
            'grouplink' => 'url'
        ]);

        foreach ($request->toArray() as $k => $d) {
            if(strstr($k, '_')) continue;
            DB::table('settings')->updateOrInsert(
                ['name' => $k, 'config' => $d],
                ['name' => $k]
            );
        }

        return back()->withStatus('Konfigurasi berhasil diperbarui');
    }
}
