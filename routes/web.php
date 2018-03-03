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

    /**
     * Averages
     */
    Route::group(['prefix' => '/average'], function () {
        Route::get('/energy/days/{days}', 'Api\ApiAveragesController@getDataOfLastDays');
        Route::get('/energy/hours/{hours}', 'Api\ApiAveragesController@getDataOfLastHours');
        Route::get('/energy/minutes/{minutes}', 'Api\ApiAveragesController@getDataOfLastMinutes');
        Route::get('/energy/last', 'Api\ApiAveragesController@getDataOfLastUpdate');
    });

    /**
     * Totals
     */
    Route::group(['prefix' => '/total'], function () {
        Route::get('/energy/days/{days}', 'Api\ApiTotalsController@getDataInDays');
        Route::get('/energy/months/{months}', 'Api\ApiTotalsController@getDataInMonths');
        Route::get('/energy/years/{years}', 'Api\ApiTotalsController@getDataInYears');
    });

    /**
     * Users
     */
    Route::group(['prefix' => '/users'], function () {
        Route::delete('{userId}', 'UserController@destroy');
        Route::put('{userId}', 'UserController@update');
    });
});
