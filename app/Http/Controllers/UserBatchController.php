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
			'mimes' => 'Format berkas yang di unggah dapat menggunakan .xls, .xlsx, .ods atau .csv',
		];

		$request->validate([
			'file' => 'required|mimes:xlsx,ods,xls,csv',
		], $messages);
		
		try {
			switch ($request->file->extension()) {
				case 'xlsx':
				Excel::import(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::XLSX);
				break;
				
				case 'xls':
				Excel::import(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::XLS);
				break;

				case 'ods':
				Excel::import(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::ODS);
				break;

				case 'csv':
				Excel::import(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::CSV);
				break;

				default:
					// code...
				break;
			}

		} catch (\Exception $e) {
			return back()->withStatus([
				'status' => 'danger',
				'message' => (strlen($e->getMessage()) > 100) ? substr($e->getMessage(), 0, 100).'...' : $e->getMessage()
			]);
		}


		return back()->withStatus(['status' => 'success', 'message' => 'Berkas berhasil di-import']);
	}
}
