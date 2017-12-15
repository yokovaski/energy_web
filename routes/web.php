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
        Route::get('/energy/days/{days}', 'ApiAveragesController@getDataOfLastDays');
        Route::get('/energy/hours/{hours}', 'ApiAveragesController@getDataOfLastHours');
        Route::get('/energy/minutes/{minutes}', 'ApiAveragesController@getDataOfLastMinutes');
        Route::get('/energy/last', 'ApiAveragesController@getDataOfLastUpdate');
    });

    /**
     * Totals
     */
    Route::group(['prefix' => '/total'], function () {
        Route::get('/energy/days/{days}', 'ApiTotalsController@getDataInDays');
        Route::get('/energy/months/{months}', 'ApiTotalsController@getDataInMonths');
        Route::get('/energy/years/{years}', 'ApiTotalsController@getDataInYears');
    });
});
