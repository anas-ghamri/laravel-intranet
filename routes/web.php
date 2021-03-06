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

Auth::routes(['register' => false]);

Route::get('verify/resend', 'Auth\TwoFactorController@resend')->name('verify.resend');
Route::resource('verify', 'Auth\TwoFactorController')->only(['index', 'store']);

Route::group(['middleware' => ['auth', 'twofactor']], function () {

	Route::get('/', 'DashboardController@index')->name('dashboard.index');

	Route::get('/customers/list', 'CustomerController@list');
	Route::resource('customers', 'CustomerController');


	// PROJECTS
	Route::get('/project/{project}/files', 'ProjectFileController@index');
	Route::patch('/project/files/{file}/update', 'ProjectFileController@update');
	Route::patch('/project/files/{file}/validate', 'ProjectFileController@validation');

	Route::get('/projects/archives', 'ProjectController@archives')->name('projects.archives');;
	Route::get('/projects/billable', 'ProjectController@billable')->name('projects.billable');;
	Route::get('/projects/{project}/restore', 'ProjectController@restore')->name('projects.restore');;
	Route::get('/projects/{project}/archive', 'ProjectController@destroy')->name('projects.archive');

	Route::get('/projects/list', 'ProjectController@list');
	Route::resource('projects', 'ProjectController');

	Route::resource('hours', 'HourController');

	Route::get('/user/hours', 'UserController@hours');
	Route::get('/user/board', 'UserController@board');

	Route::get('boards', function() {
		return view('tasks.index');
	})->name('boards.index');

	Route::resource('checklists', 'TaskChecklistController');

    Route::get('/board/{board}/tasks', 'BoardController@tasks');    
    Route::resource('/boards', 'BoardController');

	Route::get('/task/archive/{task}', 'TaskController@archive');
	Route::get('/task/{task}/duplicate', 'TaskController@duplicate');
	Route::post('/task/{task}/tags', 'TaskController@tags');
	Route::post('/task/ordering', 'TaskController@ordering');
	Route::resource('/task', 'TaskController');
	Route::resource('/tags', 'TagController');


	// ADMIN
	Route::group(['middleware' => ['admin']], function () {

		Route::get('/admin', 'AdminController@index')->name('admin.index');
		Route::get('/admin/invoices', 'AdminController@invoices')->name('admin.invoices');

		Route::get('/users/hours', 'UserController@allhours');
		Route::get('/users/list', 'UserController@getUsers');
		Route::resource('users', 'UserController');

		Route::resource('passwords', 'PasswordController');

		Route::get('/docs/list', 'DocController@list');
		Route::resource('docs', 'DocController');

		Route::get('accounts', function() {
			return view('accounts.index');
		})->name('accounts.index');

		Route::post('settings/upload', 'SettingController@upload');
		Route::resource('settings', 'SettingController');

	});

});