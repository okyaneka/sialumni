<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    function alumniStatus()
    {
        return empty($this->grad) ? 'Belum Aktif' : (date('Y') - $this->grad > 5 ? 'Tidak Aktif' : 'Aktif');
        // ;
    }

    function getProvince()
    {
        try {
            $provinces = json_decode(file_get_contents('http://dev.farizdotid.com/api/daerahindonesia/provinsi'))->semuaprovinsi;
        } catch (\Exception $e) {
            return $this->province;
        }

        foreach ($provinces as $province) {
            if ($this->province == $province->id) {
                return $province->nama;
            }
        }
    }

    function getDistrict()
    {
        try {

            $districts = json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/$this->province/kabupaten"))->kabupatens;
        } catch (\Exception $e) {
            return $this->district;
        }

        foreach ($districts as $district) {
            if ($this->district == $district->id) {
                return $district->nama;
            }
        }
    }

    function getSubDistrict()
    {
        try {
            $subdistricts = json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/$this->district/kecamatan"))->kecamatans;
        } catch (\Exception $e) {
            return $this->sub_district;
        }

        foreach ($subdistricts as $subdistrict) {
            if ($this->sub_district == $subdistrict->id) {
                return $subdistrict->nama;
            }
        }
    }


    function getAddress()
    {
        try {
            $addresses = json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/kecamatan/$this->sub_district/desa"))->desas;
        } catch (\Exception $e) {
            return $this->address;
        }

        foreach ($addresses as $address) {
            if ($this->address == $address->id) {
                return $address->nama;
            }
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nis', 'email', 'password', 'pob', 'dob', 'street', 'province', 'gender', 'address', 'sub_district', 'district', 'department', 'grad', 'phone', 'telegram',
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
