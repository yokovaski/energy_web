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
Route::get('/history', 'HomeController@history');
Route::get('/home', 'HomeController@index');

// Ajax routes
Route::get('/test', 'AjaxController@getTestData');