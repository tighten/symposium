<?php

class AuthController extends BaseController
{
	public function __construct()
	{
		$this->beforeFilter('auth', array('only' => array('account')));
	}

	public function getLogin()
	{
		return View::make('user.login');
	}

	public function postLogin()
	{
		if (Auth::attempt( array('email' => Input::get('email'), 'password' => Input::get('password')) ))
		{
			Session::flash('message', 'Successfully logged in.');
			return Redirect::intended('/');
		}

		Session::flash('error-message', 'Invalid login credentials.');
		return Redirect::to('/login');
	}

	public function logout()
	{
		Session::flash('message', 'Successfully logged out.');
		Auth::logout();

		return Redirect::to('/');
	}

	public function account()
	{
		return View::make('user.account');
	}
}
