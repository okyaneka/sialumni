<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'company',
		'position',
		'salary',
		'location',
		'poster',
		'email',
		'phone',
		'description',
		'requirements',
		'duedate',
		'seen_until',
		'raw_data'
	];

	public static function PendingJob()
	{
		return Job::where('published', '0');
	}

	public function getProvinceIdAttribute()
	{
		try {
			return json_decode($this->location)->province;
		} catch (\Throwable $th) {
			return '';
		}
	}

	public function getDistrictIdAttribute()
	{
		try {
			return json_decode($this->location)->district;
		} catch (\Throwable $th) {
			return '';
		}
	}

	public function getDistrictAttribute()
	{
		try {
			return json_decode($this->location)->street;
		} catch (\Throwable $th) {
			return '';
		}
	}

	public function getFullAddressAttribute()
	{
		$province = !empty($this->province_id) ? Location::getProvince($this->province_id)->nama : "";
		$district = !empty($this->district_id) ? Location::getDistrict($this->district_id)->nama : "";
		$street = !empty($this->street) ? "{$this->street}, " : '';

		return "{$street}{$district}, {$province}";
	}
}
