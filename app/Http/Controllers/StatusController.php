<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Status $model)
    {
        //
        return view('statuses.index', ['statuses' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Status $model)
    {
        $request->validate([
            'status'    => 'required'
        ]);

        $model->status = ucwords(strtolower($request->get('status')));
        $model->save();

        return redirect()->route('status.index')->withStatus(__('Status lulusan berhasil ditambahkan'));
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
        return view('statuses.edit', ['status' => Status::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'code'      => 'required|'.Rule::unique('statuses')->ignore(Status::find($id)),
            'status'    => 'required'
        ]);

        $status = Status::find($id);
        $status->code = strtoupper($request->get('code'));
        $status->status = ucwords(strtolower($request->get('status')));
        $status->save();

        return redirect()->route('status.index')->withStatus(__('Status lulusan berhasil diubah'));
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
        Status::find($id)->delete();

        return redirect()->route('status.index')->withStatus(__('Status lulusan berhasil dihapus.'));
    }
}
