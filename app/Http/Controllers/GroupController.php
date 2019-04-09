<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Group $model)
    {
        //
        return view('groups.index', ['groups' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $model)
    {
        //
        $request->validate([
            'grad'  => 'required|numeric|digits:4|unique:groups', 
            'link'  => 'required|url'
        ]);

        $model->grad = $request->get('grad');
        $model->link = $request->get('link');
        $model->save();

        return redirect()->route('group.index')->withStatus(__('Grup alumni berhasil ditambahkan'));
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
        return view('groups.edit', ['group' => Group::find($id)]);
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
           'grad'  => 'required|numeric|digits:4|'.Rule::unique('groups')->ignore(Group::find($id)), 
           'link'  => 'required|url'
        ]);

        $group = Group::find($id);
        $group->grad = $request->get('grad');
        $group->link = $request->get('link');
        $group->save();

        return redirect()->route('group.index')->withStatus(__('Tauntan grup alumni berhasil diubah'));

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
        Group::find($id)->delete();

        return redirect()->route('group.index')->withStatus(__('Tauntan grup alumni berhasil dihapus.'));
    }
}
