<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('', 'EntryController@index');
Route::post('handle-journal-entry', ['uses' => 'EntryController@store']);

Route::get('upload', 'EntryController@upload');
Route::post('handle-upload', ['uses' => 'EntryController@bulkStore']);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
