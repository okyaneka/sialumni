<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
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
            'total' => User::where('type','=','default')->count(),
            'active' => User::where('type','=','default')
                ->whereBetween('grad',[(date('Y') - 5), date('Y')])
                ->count(),
            'notActiveYet' => User::where('type','=','default')->whereNull('grad')->count(),
            'notActive' => User::where([
                ['type','=','default'],
                ['grad','<',(date('Y') - 5)]
            ])->count(),
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
            'status' => 'required', 
            'grad' => 'required|numeric|digits:4', 
            'phone' => 'required|numeric|digits_between:9,14', 
            'telegram' => 'required|numeric|digits_between:9,14',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->gender = $request->gender;
        // $user->email = $request->email;
        $user->province = $request->province;
        $user->district = $request->district;
        $user->sub_district = $request->sub_district;
        $user->address = $request->address;
        $user->street = $request->street;
        $user->pob = $request->pob;
        $user->dob = date('Y-m-d', strtotime($request->dob));
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
