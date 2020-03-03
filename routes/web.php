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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'ReportController@index')->name('dashboard');
    Route::resource('reports', 'ReportController')->only('index', 'show', 'update', 'destroy');
    Route::resource('users', 'UserController')
        ->except('show')
        ->middleware('powerlevel:100');
});
