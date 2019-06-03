<?php

use Illuminate\Support\Facades\Route;

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
        return redirect()->route('time.index');
    });
    Route::resource('/activity', 'ActivityController')->middleware('can:settings');
    Route::resource('/report', 'ReportController')->middleware('can:report');
    Route::resource('/user', 'UserController')->middleware('can:settings');
    Route::get('/out', 'OutController@index')->name('out');
    Route::resource('/export', 'ExportController');
    Route::resource('/time', 'TimeController');
    Route::resource('/my', 'MyActivitiesController', [
        'parameters' => [
            'my' => 'time',
        ]
    ]);
    Route::resource('/import', 'ImportController', [
        'parameters' => [
            'import' => 'project',
        ]
    ]);
    Route::resource('/auto', 'AutoController', [
        'parameters' => [
            'auto' => 'time',
        ]
    ]);
});

Route::resource('/share', 'ShareController', [
    'parameters' => [
        'share' => 'report',
    ]
]);
