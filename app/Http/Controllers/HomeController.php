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
            'province' => 'required',
            'district' => 'required', 
            'gender' => 'required',
            'pob' => 'required|alpha', 
            'dob' => 'required|date', 
            'department' => 'required', 
            'grad' => 'required|numeric|digits:4', 
            'phone' => 'required|numeric|digits_between:9,14', 
            'telegram' => 'required|numeric|digits_between:9,14',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->province = $request->province;
        $user->district = $request->district;
        $user->sub_district = $request->sub_district;
        $user->address = $request->address;
        $user->street = $request->street;
        $user->pob = $request->pob;
        $user->dob = $request->dob;
        $user->department = $request->department;
        $user->grad = $request->grad;
        $user->phone = $request->phone;
        $user->telegram = $request->telegram;

        // dd($request->toArray());

        foreach ($request->status as $status) {
            if (isset($status['id'])) {
                DB::table('user_statuses')
                    ->where('id', $status['id'])
                    ->update([
                        'user_id' => $user->id,
                        'status_id' => $status['status_id'],
                        'info' => $status['info'],
                        'year' => $status['year'],
                    ]);
            } elseif(!empty($status['status_id'])) {
                DB::table('user_statuses')->insert([
                    'user_id' => $user->id,
                    'status_id' => $status['status_id'],
                    'info' => $status['info'],
                    'year' => $status['year'],
                ]);
            }
        }

        $user->update();
        $link = '#';
        $link = '<a href="'.$link.'" target="_blank">'.$link.'</a>';

        return redirect()->route('home')->withStatus(__('Profil telah diperbaharui, klik link berikut untuk bergabung dengan grup alumni anda '.$link));
    }
}
