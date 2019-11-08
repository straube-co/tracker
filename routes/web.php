<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/time');
    }
    return redirect('/login');
});

Auth::routes(['register' => false]);

Route::group([
    'middleware' => [ 'auth' ],
], function () {
    Route::resource('/activity', 'ActivityController')->middleware('can:settings');
    // Route::post('/user/access', 'UserController@access')->name('user.access')->middleware('can:settings');
    Route::resource('/user', 'UserController')->middleware('can:settings');
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

    Route::get('/report/{format?}', 'ReportController@index')
        ->name('report.index')
        ->middleware('can:report')
        ->where('format', '^(html|csv)$');
    Route::post('/report', 'ReportController@store')
        ->name('report.store')
        ->middleware('can:report');

    Route::resource('/point', 'PointReportController');
});

Route::get('/report/{report}/{format?}', 'ReportController@show')
    ->name('report.show')
    ->where('format', '^(html|csv)$');
