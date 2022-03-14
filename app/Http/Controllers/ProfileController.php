<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    function __construct()
    {
        $this->middleware('is_data_complete');
    }

    /**
     * Show the profile
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit', array(
            'departments' => \App\Department::all(),
            'statuses' => \App\Status::all(),
        ));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        // Auth::user()->update($request->all());

        $user = Auth::user();

        $user->name = $request->name;
        $user->gender = $request->gender;
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

        return back()->withStatus(__('Profile successfully updated.'));
    }

    public function update_avatar(Request $request){

        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();

        $request->avatar->storeAs('avatars',$avatarName);

        $user->avatar = $avatarName;
        $user->update();

        return back()->withStatus('You have successfully upload image.');
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
