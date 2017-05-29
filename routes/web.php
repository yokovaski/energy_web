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

Route::get('/', function () {
    return Redirect::to('/home');
});
Route::get('/history', 'HistoryController@index');
Route::get('/home', 'HomeController@index');
Route::get('/admin', 'AdminController@index');

/**
 * Ajax routes
 */
Route::group(['prefix' => '/api'], function () {
    Route::get('/test', 'AjaxController@getTestData');
});
