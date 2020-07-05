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

Route::get('/', function () {
    return redirect()->route('times.index');
});

Auth::routes([ 'register' => false ]);

Route::get('/times', 'TimesController@index')->name('times.index');
Route::get('/times/{time}/stop', 'TimesController@stop')->name('times.stop');

Route::get('/reports', 'ReportsController@index')->name('reports.index');
Route::get('/reports/{code}/shared/{format?}', 'SharedReportController@show')
    ->name('reports.shared.show')
    ->where('format', '^(html|csv)$');

Route::get('/projects', 'ProjectsController@index')->name('projects.index');
Route::get('/activities', 'ActivitiesController@index')->name('activities.index');
Route::get('/users', 'UsersController@index')->name('users.index');
