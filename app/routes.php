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

Route::get('/login', function()
{
    return View::make('user.login');
});

Route::post('/login', function()
{
    if (Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password')) ))
    {
    	return Redirect::intended('/');
    }

	Session::flash('error-message', 'Invalid login credentials.');
	return Redirect::to('/login');
});

Route::get('/logout', function()
{
	Auth::logout();

	return Redirect::to('/');
});

Route::get('/account', array('before' => 'auth', function()
{
	return View::make('user.account');
}));

