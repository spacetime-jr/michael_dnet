<?php

Route::group(['middleware' => ['web','auth'], 'namespace' => 'Modules\Settings\Http\Controllers'], function()
{    
	Route::get('setting/delete/{id}', 'SettingsController@destroy')->name('setting.delete');
    Route::resource('setting', 'SettingsController');
});
