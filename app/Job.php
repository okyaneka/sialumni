<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $fillable = [
		'company',
		'position',
		'salary',
		'location',
		'email',
		'phone',
		'description',
		'requirements',
		'duedate',
	];

	public function getProvinceIdAttribute()
	{
		return unserialize($this->location)['province'];
	}

	public function getDistrictIdAttribute()
	{
		return unserialize($this->location)['district'];
	}
	
	public function getDistrictAttribute()
	{
		return unserialize($this->location)['street'];
	}

	public function getFullAddressAttribute()
	{
		$province = Location::getProvince($this->province_id)->nama;
		$district = Location::getDistrict($this->district_id)->nama;
		$street = $this->street ? "{$this->street}, " : '';

		return "{$street}{$district}, {$province}";
	}
}
