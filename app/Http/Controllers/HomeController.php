<?php

namespace App\Http\Controllers;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $alumnus = [
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
        ];

        return view('dashboard', $alumnus);
    }
}
