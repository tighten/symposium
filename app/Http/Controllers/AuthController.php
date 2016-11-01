<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    public function getLogin()
    {
        return view('account.log-in');
    }

    public function postLogin(Request $request)
    {
        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/dashboard');
        }

        return redirect()->route('log-in')
            ->withErrors(['auth' => ['The email or password you entered is incorrect.']]);
    }

    public function logout()
    {
        Session::flash('message', 'Successfully logged out.');
        auth()->logout();

        return redirect('/');
    }
}
