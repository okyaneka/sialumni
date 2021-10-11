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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nisn', 'email', 'password', 'pob',
        'dob', 'street', 'province_id', 'gender', 'address',
        'sub_district_id', 'district_id', 'department_slug', 'grad', 'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'province_id',
        'sub_district_id',
        'district_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

    public function isDataComplete($is_bot = false)
    {
        $ignored  = ['province_id', 'address', 'sub_district_id', 'district_id'];
        foreach ($this->fillable as $column) {
            if ($is_bot && in_array($column, $ignored)) {
                continue;
            }
            if (empty($this->$column)) return FALSE;
        }

        if (empty($this->statuses()->get()->toArray())) return FALSE;

        return TRUE;
    }

    public function getFullAddressAttribute()
    {
        if (
            $this->address &&
            $this->sub_district &&
            $this->district &&
            $this->province
        ) {
            $street = $this->street ? "{$this->street}, " : '';
            return "{$street}{$this->address}, {$this->sub_district}, {$this->district}, {$this->province}";
        }
        return;
    }

    public function getAddressAttribute()
    {
        if ($this->address_id) {
            return Location::getVillage($this->address_id)->nama;
        }
        return;
    }

    public function getSubDistrictAttribute()
    {
        if ($this->sub_district_id) {
            return Location::getSubDistrict($this->sub_district_id)->nama;
        }
        return;
    }

    public function getDistrictAttribute()
    {
        if ($this->district_id) {
            return Location::getDistrict($this->district_id)->nama;
        }
        return;
    }

    public function getProvinceAttribute()
    {
        if ($this->province_id) {
            return Location::getProvince($this->province_id)->nama;
        }
        return;
    }

    public function getStatusAttribute()
    {
        return empty($this->grad) ? 'Belum Aktif' : (date('Y') - $this->grad > 5 ? 'Tidak Aktif' : 'Aktif');
    }

    public function getLocalDobAttribute()
    {
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $time = strtotime($this->dob);
        $tanggal = date('j', $time);
        $bulan = $months[date('n', $time) - 1];
        $tahun = date('Y', $time);
        return "{$tanggal} {$bulan} {$tahun}";
    }

    public function getDepartmentAttribute()
    {
        if ($this->department_slug) {
            return $this->department()->first()->department;
        }

        return;
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_slug', 'code');
    }

    /**
     * Get the status for the user.
     *
     * @return Status
     */
    public function statuses()
    {
        return $this->belongsToMany('App\Status', 'user_statuses', 'user_id', 'status_id')->withPivot('id', 'year', 'info');
    }
}
