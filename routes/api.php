<?php

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

Route::group(
    ['as' => 'api.', 'namespace' => 'Api'],
    function () {
        Route::get('/tests', 'TestController@index');
        Route::post('/tests/{test}/complete/{hash}', 'TestController@complete');
        Route::post('/tests/{test}/autosave/{hash}', 'TestController@autosave');
        Route::post('/tests/{test}/start', 'TestController@start');
        Route::post('/tests/{test}/continue/{hash}', 'TestController@continue');

        Route::get('/pages', 'TestController@index');
        Route::get('/pages/{slug}', 'TestController@view');
    }
);

