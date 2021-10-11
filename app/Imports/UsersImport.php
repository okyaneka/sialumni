<?php

namespace App\Imports;

use App\User;
use App\Setting;
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
        if (!is_numeric($row['nisn'])) {
            return null;
        }

        $dob = $gender = '' ;

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

        return new User([
            'nisn' => $row['nisn'],
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make(date('dmY', strtotime($dob))),
            'gender' => $gender,
            'pob' => $row['tempat_lahir'],
            'dob' => $dob,
            'department_slug' => $row['jurusan'],
        ]);
    }
}
