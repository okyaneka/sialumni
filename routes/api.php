<?php

use App\User;
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

Route::get('data_test', function () {
    $users = User::whereNotNull('type');
    $admin = $users;
    $admin->where('type', User::ADMIN_TYPE);
    $student = $users;
    // $student->where('type', User::DEFAULT_TYPE);
    return response()->json([
        'total' => $users->count(),
        'admin' => $admin->get(),
        'student' => $admin,
    ]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
