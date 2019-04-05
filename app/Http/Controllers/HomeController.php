<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;

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
            'departments' => \App\Department::all(),
            'statuses' => \App\Status::all(),
        ];

        return view('dashboard', $alumnus);
    }

    public function update(Request $request)
    {
        $request->validate([
            'street' => 'required', 
            'address' => 'required', 
            'sub_district' => 'required', 
            'district' => 'required', 
            'pob' => 'required|alpha', 
            'dob' => 'required|date', 
            'department' => 'required', 
            'status' => 'required', 
            'grad' => 'required|numeric|digits:4', 
            'phone' => 'required|numeric|digits_between:9,14', 
            'telegram' => 'required|numeric|digits_between:9,14',
        ]);

        $user = Auth::user();
        $user->update($request->all());
        // $link = \App\Group::where('grad',$user->grad);
        $link = '#';
        $link = '<a href="'.$link.'" target="_blank" class="btn btn-primary">'.$link.'</a>';

        return redirect()->route('home')->withStatus(__('Profil telah diperbaharui, klik link berikut untuk bergabung dengan grup alumni anda<br>'.$link));
    }
}
