<?php

class AuthController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter('auth', array('only' => array('account')));
	}

	public function getLogin()
	{
		return View::make('user.log-in');
	}

	public function postLogin()
	{
		if (Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password')) ))
		{
			Session::flash('message', 'Successfully logged in.');
			return Redirect::intended('/talks');
		}

		Session::flash('error-message', 'Invalid login credentials.');
		return Redirect::to('log-in');
	}

	public function logout()
	{
		Session::flash('message', 'Successfully logged out.');
		Auth::logout();

		return Redirect::to('/');
	}
}
