<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
//
    function getProvinces()
    {
        return Location::getProvinces();
    }

    function getDistricts($id)
    {
        return Location::getDistricts($id);
    }

    function getSubDistricts($id)
    {
        return Location::getSubDistricts($id);
    }

    function getVillages($id)
    {
        return Location::getVillages($id);
    }
}
