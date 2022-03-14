<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		$data = User::where('type', '=', User::DEFAULT_TYPE)->get();

		$array = [];

		foreach ($data as $k => $d) {
			$array[$k] = [
				'NISN' => $d->nisn,
				'NAMA' => $d->name,
				'EMAIL' => $d->email,
				'JENIS KELAMIN' => $d->gender == 'M' ? 'Laki-laki' : 'Perempuan',
				'TEMPAT LAHIR' => $d->pob,
				'TANGGAL LAHIR' => $d->dob,
				'JURUSAN' => $d->department,
				'JALAN / DUSUN' => $d->street,
				'KELURAHAN' => $d->address,
				'KECAMATAN' => $d->sub_district,
				'KABUPATEN' => $d->district,
				'PROVINSI' => $d->province,
			];

			foreach ($d->statuses()->get() as $k2 => $d2) {
				$array[$k]["STATUS {$k2}"] = $d2->status;
				$k2 = $k2 . 'ket';
				$info = !empty($d2->pivot->info) ? $d2->status . ' di ' . $d2->pivot->info : '';
				$info .= !empty($d2->pivot->year) ? ' sampai ' . $d2->pivot->year : '';
				$array[$k]["KET STATUS {$k2}"] = $info;
			}
		}

		return collect($array);
	}

	public function headings(): array
	{
		return [
			'NISN',
			'NAMA',
			'EMAIL',
			'JENIS KELAMIN',
			'TEMPAT LAHIR',
			'TANGGAL LAHIR',
			'JURUSAN',
			'JALAN / DUSUN',
			'KELURAHAN',
			'KECAMATAN',
			'KABUPATEN',
			'PROVINSI',
			'STATUS 1',
			'KETERANGAN',
			'STATUS 1',
			'KETERANGAN',
		];
	}
}
