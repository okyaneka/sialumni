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
    	$data = User::select('id', 'nis', 'name', 'email', 'gender', 'pob', 'dob', 'department', 'street', 'address', 'sub_district', 'district', 'province')
    	->where('type','=',User::DEFAULT_TYPE)
    	->get();

    	$array = [];
    	$status = [];

    	foreach ($data as $k => $d) {
    		$array[$k] = $d;


    		$array[$k]->gender = $array[$k]->gender == 'M' ? 'Laki-laki' : 'Perempuan';
    		$array[$k]->address = $d->getAddress();
    		$array[$k]->sub_district = $d->getSubDistricts();
    		$array[$k]->district = $d->getDistricts();
    		$array[$k]->province = $d->getProvinces();

    		foreach ($d->statuses()->get() as $k2 => $d2) {
    			$array[$k]->$k2 = $d2->status;
    			$k2 = $k2.'ket';
    			$info = !empty($d2->pivot->info) ? $d2->status.' di '.$d2->pivot->info : '';
    			$info .= !empty($d2->pivot->year) ? ' sampai '.$d2->pivot->year : '';
    			$array[$k]->$k2 = $info;
    		}

    		unset($array[$k]->id);
    	}

    	return collect($array);

    }

    public function headings(): array
    {
    	return [
    		'NIS',
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
