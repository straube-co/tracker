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

Route::get('/auth', 'Auth\\OAuthController@auth')->name('auth.auth');
Route::get('/auth/handle', 'Auth\\OAuthController@handle')->name('auth.handle');

Route::group([
    'middleware' => [ 'auth' ],
], function () {
    Route::get('/', function () {
        return view('layouts/home');
    });
    Route::resource('/activity', 'ActivityController');
    Route::resource('/report', 'ReportController');
    Route::resource('/time', 'TimeController');
    Route::resource('/my', 'MyActivitiesController');
    Route::resource('/home', 'HomeController');
    Route::resource('/import', 'ImportController');
    Route::resource('/auto', 'AutoController');
});

Route::resource('/share', 'ShareController', ['parameters' => [
    'share' => 'report',
]]);
