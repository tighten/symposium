<?php namespace Symposium\Http\Controllers;

use Auth;
use Input;
use Redirect;
use Session;

class AuthController extends BaseController
{
    public function getLogin()
    {
        return view('user.log-in');
    }

    public function postLogin()
    {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')))) {
            Session::flash('message', 'Successfully logged in.');
            return Redirect::intended('/dashboard');
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
