<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Modules\Users\Http\Controllers'], function () {


    Route::get('users/do_login_api','UsersController@doLoginAPI')->name('users.dologinapi');

    Route::group(['middleware' => ['auth']], function () {

        // User
        Route::get('users/ajaxListUsers', 'UsersController@ajaxListUsers')->name('users.listUsers');
        Route::get('users/deleteUser/{id}', 'UsersController@destroy')->name('users.deleteUser');
        Route::get('users/ajaxListAutocomplete', 'UsersController@ajaxListAutocomplete')->name('users.ajaxListAutocomplete');

        
        // HR
        Route::get('hr/ajaxListHr', 'HrController@ajaxListHr')->name('hr.listHr');
        Route::get('hr/deleteHr/{id}', 'HrController@destroy')->name('hr.deleteUser');

        
        // Employee
        Route::get('employee/ajaxListEmployee', 'EmployeeController@ajaxListEmployee')->name('employee.listEmployee');
        Route::get('employee/deleteEmployee/{id}', 'EmployeeController@destroy')->name('employee.deleteUser');
        
        // Absensi
        Route::get('absensi/checkin', 'AbsensiController@checkin')->name('absensi.checkin');
        Route::get('absensi/checkout', 'AbsensiController@checkout')->name('absensi.checkout');

        // Ijin
        Route::get('ijin/ajaxListIjin', 'IjinController@ajaxListIjin')->name('ijin.listIjin');
        Route::get('absensi/checkout', 'AbsensiController@checkout')->name('absensi.checkout');
        
    
        Route::resource('users', 'UsersController');
        Route::resource('hr', 'HRController');
        Route::resource('employee', 'EmployeeController');
        Route::resource('absensi', 'AbsensiController');
        Route::resource('ijin', 'IjinController');
    });

    // Forgot
    Route::get('/forgot/passwordreset/{id}/{token}', ['as' => 'reminders.edit', 'uses' => 'UsersController@getForgot']);
    Route::post('/forgot/passwordreset/{id}/{token}', ['as' => 'reminders.update', 'uses' => 'UsersController@postForgot']);

});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['prefix' => 'v1/user', 'namespace' => 'Modules\Users\Http\Controllers'], function ($api) {
    $api->post('login', 'APIUserController@login');
    $api->group(['middleware' => ['api.auth', 'apiAuth']], function ($api) {
        // API
    });
});