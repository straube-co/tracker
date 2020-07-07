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

Route::get('/activities', 'ActivitiesController@index')->name('activities.index');
Route::post('/activities', 'ActivitiesController@store')->name('activities.store');

Route::post('/times', 'TimesController@store')->name('times.store');
Route::post('/times/{time}', 'TimesController@update')->name('times.update');

Route::post('/users', 'UsersController@store')->name('users.store');
