<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('provinsi', 'LocationController@getProvinces');
Route::get('kabupaten/{id}', 'LocationController@getDistricts');
Route::get('kecamatan/{id}', 'LocationController@getSubDistricts');
Route::get('desa/{id}', 'LocationController@getVillages');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
