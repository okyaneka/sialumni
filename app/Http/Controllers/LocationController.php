<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
//
    function getProvince()
    {
        try {
            $lokasi = json_decode(file_get_contents('http://dev.farizdotid.com/api/daerahindonesia/provinsi'));
            return response()->json($lokasi->semuaprovinsi);
        } catch (\Exception $e) {
            return response()->json([['id' => null, 'nama' => null]]);
        }

    }

    function getDistrict($id)
    {
        try {
            $lokasi = json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/$id/kabupaten"));

            return response()->json($lokasi->kabupatens);
        } catch (\Exception $e) {
            return response()->json([['id' => null, 'nama' => null]]);
        }

    }

    function getSubDistrict($id)
    {
        try {
            $lokasi = json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/$id/kecamatan"));

            return response()->json($lokasi->kecamatans);
        } catch (\Exception $e) {
            return response()->json([['id' => null, 'nama' => null]]);
        }
    }

    function getVillage($id)
    {
        try {
            $lokasi = json_decode(file_get_contents("http://dev.farizdotid.com/api/daerahindonesia/provinsi/kabupaten/kecamatan/$id/desa"));

            return response()->json($lokasi->desas);
        } catch (\Exception $e) {
            return response()->json([['id' => null, 'nama' => null]]);
        }
    }
}
