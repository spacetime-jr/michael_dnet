<?php

Route::group(['middleware' => 'web', 'prefix' => 'helper', 'namespace' => 'Modules\Helper\Http\Controllers'], function()
{
    Route::get('/', 'HelperController@index');
});
