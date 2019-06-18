<?php

namespace App\Imports;

use App\User;
use App\Config;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!is_numeric($row['nis'])) {
            return null;
        }

        return new User([
            'nis' => $row['nis'],
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make('123456'),
            'gender' => $row['jenis_kelamin'] == 'L' || strtolower($row['jenis_kelamin']) == 'laki-laki' ? 'M' : 'F',
            'dob' => date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($row['tanggal_lahir'])) ,
            'department' => $row['jurusan'],
        ]);
    }
}
