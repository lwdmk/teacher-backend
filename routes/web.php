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

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'prefix' => 'admin'
    ],
    function () {
        Auth::routes();
    }
);

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth', 'can:admin-panel'],
    ],
    function () {
        Route::post('/ajax/upload/image', 'UploadController@image')->name('ajax.upload.image');

        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('users', 'UsersController');
        Route::get('/users/{user}/tests', 'UsersController@tests')->name('users.tests');

        Route::resource('pages', 'PageController');
        Route::get('/pages/{page}/attachments', 'PageController@attachmentsForm')->name('pages.attachments');
        Route::post('/pages/{page}/attachments', 'PageController@attachments');
        Route::delete('/pages/{page}/attachments/{file}', 'PageController@deleteAttachment')->name('pages.delete.attachment');
        Route::resource('test', 'TestController');
        Route::get('/tests/{test}/attempts', 'TestController@attempts')->name('test.attempts');
        Route::get('/tests/{test}/attempt/{attempt}', 'TestController@attempt')->name('test.attempt');

        Route::group(
            ['prefix' => 'test/{test}', 'as' => 'test.'], function() {
            Route::resource('question', 'QuestionController');
            Route::post('/question/{question}/answer/store', 'AnswerController@store')->name('question.answer.store');
        });
    }
);
