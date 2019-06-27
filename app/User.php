<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isDataComplete()
    {
        foreach ($this->fillable as $column) {
            if(empty($this->$column)) return FALSE;
        }

        if (empty($this->statuses()->get()->toArray())) return FALSE;

        return TRUE;
    }

    /**
     * Get the department for the user.
     *
     * @return Department
     */
    public function department()
    {
        return $this->hasOne('App\Department','code','department');
    }

    /**
     * Get the status for the user.
     *
     * @return Status
     */
    public function statuses()
    {
        return $this->belongsToMany('App\Status', 'user_statuses', 'user_id', 'status_id')->withPivot('year', 'info');
    }

    public function alumniStatus()
    {
        return empty($this->grad) ? 'Belum Aktif' : (date('Y') - $this->grad > 5 ? 'Tidak Aktif' : 'Aktif');
        // ;
    }

    public function getProvinces()
    {
        try {
            if (empty($this->province)) {
                return 'Belum terdata';
            }

            foreach (json_decode(Storage::get('/origin/province')) as $province) {
                if ($this->province == $province->id) {
                    return trim($province->nama);
                }
            }
        } catch (\Exception $e) {
            Storage::put('/origin/province', json_encode(json_decode(file_get_contents('http://dev.farizdotid.com/api/daerahindonesia/provinsi'))->semuaprovinsi));
            return $this->getProvinces();
        }
    }

    public function getDistricts()
    {
        try {
            if (empty($this->district)) {
                return 'Belum terdata';
            }

            foreach (json_decode(Storage::get('/origin/district/'.substr($this->district, 0, 2))) as $district) {
                if ($this->district == $district->id) {
                    return trim($district->nama);   
                }
            }
        } catch (\Exception $e) {
            Storage::put('/origin/district/'.$this->province, json_encode(json_decode(file_get_contents('http://dev.farizdotid.com/api/daerahindonesia/provinsi/'.substr($this->district, 0, 2).'/kabupaten'))->kabupatens));
            return $this->getDistricts();
        }
    }

    public function getSubDistricts()
    {
        try {
            if (empty($this->sub_district)) {
                return 'Belum terdata';
            }

            foreach (json_decode(Storage::get('/origin/sub_district/'.$this->district)) as $subdistrict) {
                if ($this->sub_district == $subdistrict->id) {
                    return trim($subdistrict->nama);
                }
            }
        } catch (\Exception $e) {
            Storage::put('/origin/sub_district/'.$this->district, json_encode(json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/$this->district/kecamatan"))->kecamatans));
            return $this->getSubDistricts();
        }
    }


    public function getAddress()
    {
        try {
            if (empty($this->address)) {
                return 'Belum terdata';
            }

            foreach (json_decode(Storage::get('/origin/village/'.$this->sub_district)) as $address) {
                if ($this->address == $address->id) {
                    return trim($address->nama);
                }
            }
        } catch (\Exception $e) {
            Storage::put('/origin/village/'.$id, json_encode(json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/kecamatan/$this->sub_district/desa"))->desas));
            return $this->getAddress();
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nis', 'email', 'password', 'pob', 'dob', 'street', 'province', 'gender', 'address', 'sub_district', 'district', 'department', 'grad', 'phone', 'telegram', 'temp_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
