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

Route::post('auth/login', 'AuthController@postLogin');

Route::group(['middleware' => 'oauth'], function() {
	resourceRoute('auth', 'AuthController');
	Route::get('/', function() {
		echo 'This is protected route';
	});
});

