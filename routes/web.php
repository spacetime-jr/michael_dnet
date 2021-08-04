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


/*
  *  Auth Route
  */
Route::group(['middleware' => ['auth_admin']], function(){
	Route::get('/login', 'SiteController@login')->name('login');
	Route::post('/login', 'AuthController@login')->name('login_auth');
});
Route::any('/logout', 'AuthController@logout')->name('logout');
Route::any('/error', 'SiteController@error')->name('error');


Route::group(['middleware' => ['auth']], function(){
  Route::get('/', 'SiteController@dashboard')->name('dashboard');

  /*
  *  Activity Route
  */
  Route::get('activity/ajaxListActivity', 'ActivityController@ajaxListActivity')->name('activity.ajaxListActivity');
  Route::resource('activity', 'ActivityController');
  
  /*
  *  Media Library Route
  */
  Route::get('media/list', 'MediaController@list')->name('media.list');
  Route::get('media/slideshowlist', 'MediaController@slideshowlist')->name('media.slideshowlist');
  Route::get('media/listImage', 'MediaController@listImage')->name('media.listImage');
  Route::resource('media', 'MediaController');
  
  /*
  *  User Route
  */
  Route::resource('user', 'UserController');
  Route::group(['prefix' => 'user'], function(){
	Route::any('change-status/{status}/{id}', 'UserController@changeStatus')->name('user.changeStatus');
  });
  
  /*
  *  User Role Route
  */
  Route::resource('role', 'RoleController');

  /*
  *  Module Route
  */
  Route::resource('module', 'ModuleController');
  Route::group(['prefix' => 'module'], function(){
    Route::any('change-status/{name}/{status}', 'ModuleController@changeStatus')->name('module.changeStatus');
  });

});

/*
*  API Route
*/
Route::group(['prefix' => 'api/v1'], function(){
  Route::get('docs', function(){
	return View::make('docs.api.v1.index');
  })->name('apidocs');
  
  Route::get('getUsers', 'ApiController@getUsers');
  Route::get('getUserInfo', 'ApiController@getUserInfo');
  Route::post('updateUserInfo', 'ApiController@updateUserInfo');
});
