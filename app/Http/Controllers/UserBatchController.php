<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use App\User;
use Illuminate\Support\Facades\Hash;
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

		$data = null;

		try {
			switch ($request->file->extension()) {
				case 'xlsx':
					$data =	Excel::toCollection(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::XLSX);
					break;

				case 'xls':
					$data = Excel::toCollection(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::XLS);
					break;

				case 'ods':
					$data = Excel::toCollection(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::ODS);
					break;

				case 'csv':
					$data = Excel::toCollection(new UsersImport, $request->file, null, \Maatwebsite\Excel\Excel::CSV);
					break;

				default:
					// code...
					break;
			}
		} catch (\Exception $e) {
			return back()->withStatus([
				'status' => 'danger',
				'message' => (strlen($e->getMessage()) > 100) ? substr($e->getMessage(), 0, 100) . '...' : $e->getMessage()
			]);
		}

		$count = $fail = 0;
		foreach ($data[0] as $row) {
			try {
				$this->addUser($row);
				$count++;
			} catch (\Throwable $th) {
				\Log::error($th);
				$fail++;
			}
		}

		return back()->withStatus(['status' => 'success', 'message' => "Berkas berhasil di-import: $count data berhsil ditambahkan"]);
	}

	private function addUser($row)
	{
		if (!is_numeric($row['nisn'])) {
			throw new \Exception("Nisn empty", 1);
		}
		if (empty($row['nama'])) {
			throw new \Exception("nama empty", 1);
		}
		if (empty($row['email'])) {
			throw new \Exception("email empty", 1);
		}
		if (empty($row['jenis_kelamin'])) {
			throw new \Exception("jenis_kelamin empty", 1);
		}
		if (empty($row['tanggal_lahir'])) {
			throw new \Exception("tanggal_lahir empty", 1);
		}
		if (empty($row['jurusan'])) {
			throw new \Exception("jurusan empty", 1);
		}

		$dob = $gender = '';

		if (is_numeric($row['tanggal_lahir'])) {
			$dob = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row['tanggal_lahir']));
		} else {
			$dob = date('Y-m-d', strtotime($row['tanggal_lahir']));
		}

		if ($row['jenis_kelamin'] == 'L' || strtolower($row['jenis_kelamin']) == 'laki-laki') {
			$gender = 'M';
		}

		if ($row['jenis_kelamin'] == 'P' || strtolower($row['jenis_kelamin']) == 'perempuan') {
			$gender = 'F';
		}

		if (empty($row['email'])) {
			throw new \Exception("data empty", 1);
		}

		$user = User::create(
			[
				'nisn' => $row['nisn'],
				'name' => ucwords(strtolower($row['nama'])),
				'email' => strtolower($row['email']),
				'password' => Hash::make(date('dmY', strtotime($dob))),
				'gender' => $gender,
				'pob' => $row['tempat_lahir'],
				'dob' => $dob,
				'department_slug' => $row['jurusan'],
			]
		);
		return $user;
	}
}
