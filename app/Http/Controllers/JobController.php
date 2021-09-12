<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Job $job)
    {
        $filter = [];

        // if (!empty($_GET['submit'])) {
        if (!empty($_GET['company']))
            $filter[] = ['company', 'like', '%' . $_GET['company'] . '%'];

        $jobs = $job->where($filter)->paginate(15);
        return view('jobs.index', ['jobs' => $jobs, 'filter' => $filter]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request, Job $job)
    {
        $requirements = [];

        foreach ($request->requirements as $r) {
            if (!empty($r)) {
                $requirements[] = $r;
            }
        }

        $job->create([
            'company' => $request->company,
            'position' => $request->position,
            'salary' => $request->salary,
            'location' => serialize([
                "province" => $request->province,
                "district" => $request->district,
                "street" => $request->street,
            ]),
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'requirements' => serialize($requirements),
            'duedate' => date('Y-m-d', strtotime($request->duedate)),
        ]);

        return redirect()->route('job.index')->withStatus('Lowongan kerja telah berhasil ditambahkan');
    }

    /**
     * Display the all resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function showAll(Job $jobs)
    {
        //
        $filter = [];
        if (!empty($_GET['company'])) {
            $filter[] = ['company', 'like', '%' . $_GET['company'] . '%'];
        }

        $jobs = $jobs->where($filter);
        $jobs = $jobs->where('duedate', '>', date('Y-m-d'))->paginate(12);

        return view('jobs.showall', compact('jobs', 'filter'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        $requirements = [];

        foreach ($request->requirements as $r) {
            if (!empty($r)) {
                $requirements[] = $r;
            }
        }

        $job->company = $request->company;
        $job->position = $request->position;
        $job->salary = $request->salary;
        $job->location = serialize([
            "province" => $request->province,
            "district" => $request->district,
            "sub_district" => $request->sub_district,
            "address" => $request->address,
            "street" => $request->street,
        ]);
        $job->email = $request->email;
        $job->phone = $request->phone;
        $job->description = $request->description;
        $job->requirements = serialize($requirements);
        $job->duedate = date('Y-m-d', strtotime($request->duedate));

        $job->update();

        return redirect()->route('job.index')->withStatus('Data lowongan kerja berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
        $job->delete();

        return redirect()->route('job.index')->withStatus('Data lowongan kerja berhasil dihapus');
    }
}
