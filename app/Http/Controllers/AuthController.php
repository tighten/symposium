<?php namespace Symposium\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    public function getLogin()
    {
        return view('user.log-in');
    }

    public function postLogin()
    {
        if (Auth::attempt(Request::only('email', 'password'))) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->route('log-in')
            ->withErrors(['auth' => ['The email or password you entered is incorrect.']]);
    }

    public function logout()
    {
        Session::flash('message', 'Successfully logged out.');
        Auth::logout();

        return redirect('/');
    }
}
