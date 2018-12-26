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

Route::middleware('auth')->group(function () {
    Route::get('/filters', 'FiltersController@index');
    Route::get('/filters/all', 'FiltersController@all');
    Route::post('/filters/create', 'FiltersController@create');
    Route::post('/filters/delete', 'FiltersController@delete');
});

Route::get('/', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/testMail', 'HomeController@test');

Auth::routes();
