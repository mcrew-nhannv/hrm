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

Route::get('test', function(){
	echo md5(time());
});

Route::get('login', 'UserController@GetLogin');
Route::post('login', 'UserController@PostLogin');
Route::get('logout', 'UserController@GetLogout');

Route::group(['prefix'=>'admin' , 'middleware'=>'AdminLogin'],function(){
	Route::get('index', function(){
		return view('admin.pages.index');
	});

	Route::get('register', 'UserController@GetRegister');
	Route::post('register', 'UserController@PostRegister');

	Route::group(['prefix'=>'users'], function(){
		Route::get('list', 'UserController@GetListUsersForAdmin');
		Route::get('delete/{id}', 'UserController@GetDeleteUser');
	});
});

Route::group(['prefix'=>'staff', 'middleware'=>'PreventMem'], function(){
	Route::get('index', function(){
		return view('staff.pages.index');
	});

	Route::group(['prefix'=>'users'], function(){
		Route::get('list', 'UserController@GetListUsersForStaff');
	});
});

Route::group(['prefix'=>'member'], function(){
	Route::get('index', function(){
		return view('member.pages.index');
	});
});

Route::group(['prefix'=>'user'], function(){
	Route::get('edit/{id}', 'UserController@GetEdit')->middleware('login');
	Route::post('edit/{id}', 'UserController@PostEdit');
});


Route::group(['prefix'=>'projects', 'middleware'=>'PreventMem'], function(){

	Route::get('list', 'ProjectsController@GetList');

});

Route::get('mempage', function(){
	return view('mempage');
})->middleware('login');