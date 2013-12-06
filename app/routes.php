<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('home');
});

Route::get('how-do-i', function() {
	return View::make('how-do-i');
});

Route::get('log-in', 'AuthController@getLogin');
Route::post('log-in', 'AuthController@postLogin');
Route::get('log-out', 'AuthController@logout');

Route::get('sign-up', 'AccountController@create');
Route::post('sign-up', 'AccountController@store');

Route::get('account', 'AccountController@show');
Route::get('account/edit', 'AccountController@edit');
Route::post('account/edit', 'AccountController@update');
Route::get('account/delete', 'AccountController@delete');
Route::post('account/delete', 'AccountController@destroy');

Route::get('styles/preview/{id}', 'StylesController@preview');

Route::resource('styles', 'StylesController');
Route::resource('authors', 'AuthorsController');
