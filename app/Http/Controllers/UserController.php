<?php

namespace App\Http\Controllers;

use App\User;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        if (!empty($_GET['status']))
            $model = Status::find($_GET['status'])->users();
        // dd($model);
        // $filter[] = ['status', '=', $_GET['status']];

        $model = $model->where('type', '=', User::DEFAULT_TYPE);
        if (Auth::user()->isAdmin() == FALSE) {
            $model = $model->whereNotNull('grad');
        }

        $filter = [];

        // if (!empty($_GET['submit'])) {
        if (!empty($_GET['nama']))
            $filter[] = ['name', 'like', '%' . $_GET['nama'] . '%'];

        if (!empty($_GET['jurusan']))
            $filter[] =  ['department_slug', '=', $_GET['jurusan']];

        if (!empty($_GET['tahun']))
            $filter[] = ['grad', '=', $_GET['tahun']];

        if (!empty($_GET['gender']))
            $filter[] = ['gender', '=', $_GET['gender']];

        // return empty($this->grad) ? 'Belum Aktif' : (date('Y') - $this->grad > 5 ? 'Tidak Aktif' : 'Aktif');

        // } elseif (!empty($_GET['nama'])) {
        //     $filter[] = ['name', 'like', '%'.$_GET['nama'].'%'];
        // }

        if (!empty($_GET['alumnistatus'])) {
            switch ($_GET['alumnistatus']) {
                case 'aktif':
                    $model = $model->whereBetween('grad', [(date('Y') - 5), date('Y')]);
                    $filter[] = ['grad', 'like', '%%'];
                    break;
                case 'belum_aktif':
                    $model = $model->whereNull('grad');
                    $filter[] = ['grad', 'like', '%%'];
                    break;
                case 'tidak_aktif':
                    $filter[] = ['grad', '<', (date('Y') - 5)];
                    break;
                default:
                    // code...
                    break;
            }
        }

        $users = $model->where($filter)->paginate(15);
        return view('users.index', ['users' => $users, 'filter' => $filter]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        if ($user->isAdmin()) {
            abort(404);
        }

        if (is_null($user)) {
            abort(503, 'User not found');
        }

        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, User $user)
    {
        $user->create(
            $request->merge([
                'dob' => date('Y-m-d', strtotime($request->dob)),
                'password' => Hash::make(date('dmY', strtotime($request->dob))),
            ])->all()
        );

        return redirect()->route('user.index')->withStatus(__('User successfully created.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        // $user = array_push([
        // 'departments' => \App\Department::all(),
        // 'statuses' => \App\Status::all(),
        // ], $user);
        return view('users.edit', [
            'user' => $user,
            'departments' => \App\Department::all(),
            'statuses' => \App\Status::all(),
        ]);
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
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

        if ($request->status) {
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
                } elseif (!empty($status['status_id'])) {
                    DB::table('user_statuses')->insert([
                        'user_id' => $user->id,
                        'status_id' => $status['status_id'],
                        'info' => $status['info'],
                        'year' => $status['year'],
                    ]);
                }
            }
        }

        $user->update();

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }
}
