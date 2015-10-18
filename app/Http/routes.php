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

Route::get( '', 'LoggerController@index' );
Route::post( 'new-journal-entry', array( 'uses' => 'LoggerController@store' ) );

Route::get( 'upload', 'LoggerController@upload' );
Route::post( 'new-upload', array( 'uses' => 'LoggerController@bulk_store' ) );

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
