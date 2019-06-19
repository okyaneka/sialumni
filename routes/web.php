<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::match(['get', 'post'], '/telegram', 'TelegramController@handle');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('api/provinsi', 'LocationController@getProvince');
Route::get('api/kabupaten/{id}', 'LocationController@getDistrict');
Route::get('api/kecamatan/{id}', 'LocationController@getSubDistrict');
Route::get('api/desa/{id}', 'LocationController@getVillage');

Route::group(['middleware' => 'auth'], function () {
	Route::post('/home', 'HomeController@update')->name('home.update');

	Route::resource('user', 'UserController');

	Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@show']);
	Route::get('profile/edit', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile/edit', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('setting/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
	Route::put('setting/avatar', ['as' => 'profile.avatar', 'uses' => 'ProfileController@update_avatar']);
	// Route::put('setting/email', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

	Route::get('statistic', ['as' => 'statistic.index', 'uses' => 'StatisticController@index']);
	Route::get('statistic/grad', ['as' => 'statistic.grad', 'uses' => 'StatisticController@grad']);
	Route::get('statistic/origin', ['as' => 'statistic.origin', 'uses' => 'StatisticController@origin']);
	Route::get('statistic/department', ['as' => 'statistic.department', 'uses' => 'StatisticController@department']);
	Route::get('statistic/status', ['as' => 'statistic.status', 'uses' => 'StatisticController@status']);
	Route::get('statistic/gender', ['as' => 'statistic.gender', 'uses' => 'StatisticController@gender']);

	Route::middleware('is_admin')->group(function () {
		Route::get('/admin', 'AdminController@admin')->name('admin');
		Route::resource('department', 'DepartmentController', ['except' => ['show']]);
		Route::resource('status', 'StatusController', ['except' => ['show']]);
		Route::resource('group', 'GroupController', ['except' => ['show']]);

		Route::get('batch/user', 'UserBatchController@batch')->name('user.batch');
		Route::put('batch/user', 'UserBatchController@insertBatch')->name('user.insert_batch');

		Route::get('download', 'DownloadDataController@index')->name('download');
	});

	Route::get('setting', 'SettingController@get')->name('setting.get');
	Route::put('setting', 'SettingController@set')->name('setting.set');
});

