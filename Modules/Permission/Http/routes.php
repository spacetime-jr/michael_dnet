<?php

Route::group(['middleware' => ['web','auth'], 'namespace' => 'Modules\Permission\Http\Controllers'], function()
{
  
 	Route::get('permission/delete/{id}', 'PermissionController@destroy')->name('permission.delete');
    Route::resource('permission', 'PermissionController');
});
