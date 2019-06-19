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

		try {
			Excel::import(new UsersImport, $request->file);	
		} catch (\Exception $e) {
			return back()->withStatus([
				'status' => 'danger',
				'message' => (strlen($e->getMessage()) > 100) ? substr($e->getMessage(), 0, 100).'...' : $e->getMessage()
			]);
		}


		return back()->withStatus(['status' => 'success', 'message' => 'Berkas berhasil di-import']);
	}
}
