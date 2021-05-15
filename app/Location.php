<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Location extends Model
{
    static function getProvinces()
    {
        try {
            return json_decode(Storage::get('/origin/province'));
        } catch (\Exception $e) {
            Storage::put('/origin/province', json_encode(json_decode(file_get_contents('https://dev.farizdotid.com/api/daerahindonesia/provinsi'))->provinsi));
            return Location::getProvinces();
        }
    }

    static function getDistricts($id)
    {
        try {
            return json_decode(Storage::get('/origin/district/'.$id));
        } catch (\Exception $e) {
            Storage::put('/origin/district/'.$id, json_encode(json_decode(file_get_contents("https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=$id"))->kota_kabupaten));
            return Location::getDistricts($id);
        }
    }

    static function getSubDistricts($id)
    {
        try {
            return json_decode(Storage::get('/origin/sub_district/'.$id));
        } catch (\Exception $e) {
            Storage::put('/origin/sub_district/'.$id, json_encode(json_decode(file_get_contents("https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=$id"))->kecamatan));
            return Location::getSubDistricts($id);
        }
    }

    static function getVillages($id)
    {
        try {
            return json_decode(Storage::get('/origin/village/'.$id));
        } catch (\Exception $e) {
            Storage::put('/origin/village/'.$id, json_encode(json_decode(file_get_contents("https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=$id"))->kelurahan));
            return Location::getVillages($id);
        }
    }

    static function getProvince($id)
    {
        foreach (Location::getProvinces() as $v) {
            if ($id == $v->id) {
                return $v;
            }
        }
    }

    static function getDistrict($id)
    {
        $prov_id = substr($id, 0, 2);
        foreach (Location::getDistricts($prov_id) as $v) {
            if ($id == $v->id) {
                return $v;
            }
        }
    }

    static function getSubDistrict($id)
    {
        $dist_id = substr($id, 0, 4);
        foreach (Location::getSubDistricts($dist_id) as $v) {
            if ($id == $v->id) {
                return $v;
            }
        }
    }

    static function getVillage($id)
    {
        $subd_id = substr($id, 0, 7);
        foreach (Location::getVillages($subd_id) as $v) {
            if ($id == $v->id) {
                return $v;
            }
        }
    }
}
