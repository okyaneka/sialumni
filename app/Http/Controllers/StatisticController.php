<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;

class StatisticController extends Controller
{
    //
    public function index()
    {
    	$statistics = [
    		'by_alumnus' => User::selectRaw('year(created_at) as Tahun, count(name) as Jumlah')
    			->where('type','default')
    			->groupBy('Tahun')
    			->orderBy('Tahun', 'asc')
    			->limit('5')
    			->get()->toArray(),
    		'by_department' => User::selectRaw('department as Jurusan, count(name) as Jumlah')
    			->where('type','default')
    			->groupBy('Jurusan')
    			->get()->toArray(),
    		'by_status'	=> User::selectRaw('status as Status, count(name) as Jumlah')
    			->where('type','default')
    			->groupBy('Status')
    			->get()->toArray(),
    		'by_region' => User::selectRaw('address as Desa, count(name) as Jumlah')
    			->where('type','default')
    			->groupBy('Desa')
    			->get()->toArray(),
    		'by_grad' => User::selectRaw('grad as Lulusan, count(name) as Jumlah')
    			->where('type','default')
    			->groupBy('Lulusan')
    			->get()->toArray(),
    		'total' => '124',
    		'inputed' => DB::table('users')->where('type','default')->count(),
    		'last_year' => DB::table('users')
    		    ->where('type','default')
    		    ->whereYear('created_at',(date('Y')-1))
    		    ->count(),
    		'this_year' => DB::table('users')
    		    ->where('type','default')
    		    ->whereYear('created_at',date('Y'))
    		    ->count(),
    		'max' => [
    		    'count' => 1,
    		    'field' => 'TKJ'
    		],
    		'departments' => \App\Department::all(),
    		'statuses' => \App\Status::all(),
    	];

    	return view('statistics.index', $statistics);
    }

    function last5yearS()
    {
        $statistics = User::selectRaw('year(created_at) as Tahun, count(name) as Jumlah')
            ->where('type','default')
            ->groupBy('Tahun')
            ->orderBy('Tahun', 'asc')
            ->limit('5')
            ->get();
        return view('statistics.last5years', ['statistics' => $statistics]);
    }

    function department()
    {
        $statistics = User::selectRaw('department as Jurusan, count(name) as Jumlah')
            ->where('type','default')
            ->groupBy('Jurusan')
            ->get();
        return view('statistics.department', ['statistics' => $statistics]);
    }

    function status()
    {
        $statistics = User::selectRaw('status as Status, count(name) as Jumlah')
            ->where('type','default')
            ->groupBy('Status')
            ->get();
        return view('statistics.status', ['statistics' => $statistics]);
    }

    function grad()
    {
        $statistics = User::selectRaw('grad as Lulusan, count(name) as Jumlah')
            ->where('type','default')
            ->groupBy('Lulusan')
            ->get();
        return view('statistics.grad', ['statistics' => $statistics]);
    }
    
    function region()
    {
        $statistics = User::selectRaw('address as Desa, count(name) as Jumlah')
            ->where('type','default')
            ->groupBy('Desa')
            ->get();
        return view('statistics.region', ['statistics' => $statistics]);
    }
}
