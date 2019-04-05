<?php

namespace App\Http\Controllers;

use App\Department;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $model)
    {
        //
        return view('departments.index', ['departments' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request, Department $model)
    {
        //
        $model->code = strtoupper($request->get('code'));
        $model->department = ucwords(strtolower($request->get('department')));
        $model->save();

        return redirect()->route('department.index')->withStatus(__('Jurusan berhasil ditambahkan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('departments.edit', ['department' => Department::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        $department = Department::find($id);
        $department->code = strtoupper($request->get('code'));
        $department->department = ucwords(strtolower($request->get('department')));
        $department->save();

        return redirect()->route('department.index')->withStatus(__('Jurusan berhasil diubah'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Department::find($id)->delete();

        return redirect()->route('department.index')->withStatus(__('Jurusan berhasil dihapus.'));
    }
}
