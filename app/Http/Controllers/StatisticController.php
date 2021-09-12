<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    //
    public function index()
    {
        $statistics = [
            'total' => User::where('type', '=', 'default')->whereNotNull('grad')->count(),
            'notActiveYet' => User::where('type', '=', 'default')->whereNull('grad')->count(),
            'active' => User::where('type', '=', 'default')
                ->whereBetween('grad', [(date('Y') - 5), date('Y')])
                ->count(),
            'notActive' => User::where([
                ['type', '=', 'default'],
                ['grad', '<', (date('Y') - 5)]
            ])->count(),
            'grads' =>  User::groupBy('grad')
                ->select('grad', DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->orderBy('grad', 'desc')
                ->get(),
            'origin' => User::groupBy('district_id')
                ->select('district_id', DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->orderBy('total', 'desc')
                ->get(),
            'departments' => User::groupBy('department_slug')
                ->select('department_slug', DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->orderBy('total', 'desc')
                ->get(),
            'statuses' => DB::table('statuses')
                ->join('user_statuses', 'statuses.id', '=', 'user_statuses.status_id')
                ->select(DB::raw('statuses.id, statuses.status, count(*) as total'))
                ->groupBy(['statuses.id', 'statuses.status'])
                ->get(),
            'gender' => User::groupBy('gender')
                ->select('gender', DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->orderBy('total', 'desc')
                ->get(),
            [
                'M' => User::where(['type' => 'default', 'gender' => 'M'])->count(),
                'F' => User::where(['type' => 'default', 'gender' => 'F'])->count(),
            ],

        ];

        return view('statistics.index', $statistics);
    }

    public function grad()
    {
        $statistics = [
            'total' => User::groupBy('grad')
                ->select(DB::raw('grad as `key`, count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->orderBy('key', 'desc')
                ->get(),
            'five' => User::groupBy('grad')
                ->select(DB::raw('grad as `key`, count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->orderBy('key', 'desc')
                ->limit(5)
                ->get(),
            'three' => User::groupBy('grad')
                ->select(DB::raw('grad as `key`, count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->orderBy('key', 'desc')
                ->limit(3)
                ->get(),
            'one' => User::groupBy('grad')
                ->select(DB::raw('grad as `key`, count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->orderBy('key', 'desc')
                ->limit(1)
                ->get(),
            'key' => 'Tahun',
        ];

        return view('statistics.grad', $statistics);
    }

    public function origin()
    {
        $statistics = [
            'total' => User::groupBy('district_id')
                ->select(DB::raw('district_id'), DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->get(),
            'five' => User::groupBy('district_id')
                ->select(DB::raw('district_id'), DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->where('grad', '>', date('Y') - 5)
                ->get(),
            'three' => User::groupBy('district_id')
                ->select(DB::raw('district_id'), DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->where('grad', '>', date('Y') - 3)
                ->get(),
            'one' => User::groupBy('district_id')
                ->select(DB::raw('district_id'), DB::raw('count(*) as total'))
                ->where('type', 'default')
                ->whereNotNull('grad')
                ->where('grad', '>', date('Y') - 1)
                ->get(),
            'key' => 'Asal Kabupaten',
        ];

        return view('statistics.origin', $statistics);
    }

    public function department()
    {
        $column = 'grad';
        foreach (\App\Department::all() as $d) {
            $column .= ",SUM(IF(department_slug = '$d->code', total, 0)) as $d->code";
        }

        $user = User::groupBy(['grad', 'department_slug'])
            ->select(DB::raw('grad, department_slug, count(*) as total'))
            ->where('type', 'default')
            ->whereNotNull('grad')
            ->orderBy('grad', 'desc');

        $statistics = [
            'department' => \App\Department::all(),
            'total' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->get(),
            'five' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 5)
                ->get(),
            'three' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 3)
                ->get(),
            'one' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 1)
                ->get(),
            'key' => 'Tahun',
        ];

        return view('statistics.department', $statistics);
    }

    public function status()
    {
        $user = User::groupBy(['users.grad', 'statuses.status'])
            ->join('user_statuses', 'users.id', '=', 'user_statuses.user_id')
            ->join('statuses', 'statuses.id', '=', 'user_statuses.status_id')
            ->select(DB::raw('users.grad, statuses.status, count(*) as total'))
            ->where('users.type', 'default')
            ->whereNotNull('users.grad')
            // ->
            ->orderBy('grad', 'desc');

        $column = 'grad';
        foreach (\App\Status::all() as $s) {
            $column .= ",SUM(IF(status = '$s->status', total, 0)) as `$s->status`";
        }

        $statistics = [
            'status' => \App\Status::all(),
            'total' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->get(),
            'five' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 5)
                ->get(),
            'three' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 3)
                ->get(),
            'one' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 1)
                ->get(),
            'key' => 'Tahun Lulus'
        ];

        return view('statistics.status', $statistics);
    }

    public function gender()
    {
        $column = 'grad';
        $column .= ",SUM(IF(gender = 'M', total, 0)) as M";
        $column .= ",SUM(IF(gender = 'F', total, 0)) as F";

        $user = User::groupBy('grad', 'gender')
            ->select(DB::raw('grad, gender, count(*) as total'))
            ->where('type', 'default')
            ->whereNotNull('grad')
            ->orderBy('grad', 'desc');

        $statistics = [
            'total' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->get(),
            'five' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 5)
                ->get(),
            'three' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 3)
                ->get(),
            'one' => DB::table(DB::raw("({$user->toSql()}) as user"))
                ->mergeBindings($user->getQuery())
                ->groupBy('grad')
                ->select(DB::raw($column))
                ->where('grad', '>', date('Y') - 1)
                ->get(),
            'key' => 'Jenis Kelamin',
        ];

        return view('statistics.gender', $statistics);
    }
}
