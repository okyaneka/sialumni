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

Route::middleware('is_not_installed')->group(function () {
	Route::prefix('setup')->name('setup.')->group(function () {
		Route::get('/', 'SetupController@index')->name('index');
		Route::post('/', 'SetupController@store')->name('store');
	});
});

Route::match(['get', 'post'], '/telegram/' . env('TELEGRAM_WEBHOOK'), 'TelegramController@handle');

Route::middleware('is_installed')->group(function () {
	Auth::routes();

	Route::get('/setup/status', 'SetupController@status')->name('setup.status');

	Route::get('/', 'HomeController@index');

	Route::get('job/{job}/show', ['as' => 'job.show', 'uses' => 'JobController@show']);
	Route::get('job/showall', ['as' => 'job.showall', 'uses' => 'JobController@showAll']);

	Route::group(['middleware' => 'auth'], function () {
		Route::get('/home', 'HomeController@home')->name('home');
		Route::post('/home', 'HomeController@update')->name('home.update');

		Route::resource('user', 'UserController');

		Route::get('profile', ['as' => 'profile', 'uses' => 'ProfileController@show']);
		Route::get('profile/edit', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
		Route::put('profile/edit', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
		Route::put('setting/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
		Route::put('setting/avatar', ['as' => 'profile.avatar', 'uses' => 'ProfileController@update_avatar']);
		// Route::put('setting/email', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);

		Route::middleware('is_admin')->group(function () {
			Route::get('/admin', 'AdminController@admin')->name('admin');
			Route::resource('department', 'DepartmentController', ['except' => ['show']]);
			Route::resource('status', 'StatusController', ['except' => ['show']]);
			Route::resource('group', 'GroupController', ['except' => ['show']]);
			Route::resource('job', 'JobController', ['except' => ['show']]);
			Route::get('/job/pending', 'JobController@pending')->name('job.pending');
			Route::get('/job/{job}/review', 'JobController@review')->name('job.review');

			Route::get('batch/user', 'UserBatchController@batch')->name('user.batch');
			Route::put('batch/user', 'UserBatchController@insertBatch')->name('user.insert_batch');

			Route::get('statistic', ['as' => 'statistic.index', 'uses' => 'StatisticController@index']);
			Route::get('statistic/grad', ['as' => 'statistic.grad', 'uses' => 'StatisticController@grad']);
			Route::get('statistic/origin', ['as' => 'statistic.origin', 'uses' => 'StatisticController@origin']);
			Route::get('statistic/department', ['as' => 'statistic.department', 'uses' => 'StatisticController@department']);
			Route::get('statistic/status', ['as' => 'statistic.status', 'uses' => 'StatisticController@status']);
			Route::get('statistic/gender', ['as' => 'statistic.gender', 'uses' => 'StatisticController@gender']);

			Route::get('download', 'DownloadDataController@index')->name('download');
			Route::put('download', 'DownloadDataController@download')->name('download.download');
		});

		Route::get('setting', 'SettingController@get')->name('setting.get');
		Route::put('setting', 'SettingController@set')->name('setting.set');
	});
});
