<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use App\User;
use App\Job;
use App\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'total' => User::where('type','=','default')
                ->whereNotNull('grad')
                ->count(),
            'statuses' => DB::table('statuses')
            ->join('user_statuses','statuses.id','=','user_statuses.status_id')
            ->select(DB::raw('statuses.id, statuses.status, count(*) as total'))
            ->groupBy(['statuses.id', 'statuses.status'])
            ->orderBy('total', 'desc')
            ->get(),
            'jobs' => Job::where('duedate','>',date('Y-m-d'))->orderBy('duedate', 'desc')->limit(12)->get(),
        ];

        return view('welcome', ['data' => $data]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function home()
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
            'department' => Department::count(),
            'status' => Status::count(),
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
            // 'status' => 'required', 
            'grad' => 'required|numeric|digits:4', 
            'phone' => 'required|numeric|digits_between:9,14', 
            // 'telegram' => 'required|numeric|digits_between:9,14',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->gender = $request->gender;
        // $user->email = $request->email;
        $user->province_id = $request->province;
        $user->district_id = $request->district;
        $user->sub_district_id = $request->sub_district;
        $user->address_id = $request->address;
        $user->street = $request->street;
        $user->pob = $request->pob;
        $user->dob = date('Y-m-d', strtotime($request->dob));
        $user->department_slug = $request->department;
        $user->grad = $request->grad;
        $user->phone = $request->phone;

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

        return redirect()->route('home')->withStatus(__('Anda terdaftar sebagai alumni SMK N Pringsurat dengan<br>NISN : '.$user->nisn.'<br>Password : '.date('dmY', strtotime($user->dob)).'<br>Profil telah diperbaharui, klik link berikut untuk bergabung dengan grup alumni anda '.$link));
    }
}
