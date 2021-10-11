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

	public function getProvinceIdAttribute()
	{
		return json_decode($this->location)->province;
	}

	public function getDistrictIdAttribute()
	{
		return json_decode($this->location)->district;
	}

	public function getDistrictAttribute()
	{
		return json_decode($this->location)->street;
	}

	public function getFullAddressAttribute()
	{
		$province = Location::getProvince($this->province_id)->nama;
		$district = Location::getDistrict($this->district_id)->nama;
		$street = $this->street ? "{$this->street}, " : '';

		return "{$street}{$district}, {$province}";
	}
}
