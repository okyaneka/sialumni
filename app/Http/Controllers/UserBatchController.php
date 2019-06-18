<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserBatchController extends Controller
{
    //
	function batch()
	{
		return view('users.batch');
	}

	/**
	 * Insert batch of users
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse 
	 */

	function insertBatch(Request $request)
	{

		// dd($request->file->getMimeType());

		$messages = [
		    'mimetypes' => 'Format berkas yang di unggah harus .xlsx.',
		];

		$request->validate([
			'file' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		], $messages);

		Excel::import(new UsersImport, $request->file);

		return back()->withStatus('Berkas berhasil di-import');
	}
}
