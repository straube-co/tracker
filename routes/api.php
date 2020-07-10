<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/projects', 'ProjectsController@index')->name('projects.index');
Route::post('/projects', 'ProjectsController@store')->name('projects.store');
Route::put('/projects/{project}', 'ProjectsController@update')->name('projects.update');

Route::get('/activities', 'ActivitiesController@index')->name('activities.index');
Route::post('/activities', 'ActivitiesController@store')->name('activities.store');
Route::put('/activities/{activity}', 'ActivitiesController@update')->name('activities.update');

Route::post('/times', 'TimesController@store')->name('times.store');
Route::put('/times/{time}', 'TimesController@update')->name('times.update');
Route::delete('/times/{time}', 'TimesController@destroy')->name('times.destroy');

Route::get('/users', 'UsersController@index')->name('users.index');
Route::post('/users', 'UsersController@store')->name('users.store');
Route::put('/users/{user}', 'UsersController@update')->name('users.update');

Route::get('/timezones', 'TimezonesController@index')->name('timezones.index');
Route::get('/timezones/search', 'TimezonesController@search')->name('timezones.search');

Route::post('/reports', 'ReportsController@store')->name('reports.store');
