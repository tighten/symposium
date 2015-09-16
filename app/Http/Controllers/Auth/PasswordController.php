<?php namespace Symposium\Http\Controllers\Auth;

use Symposium\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/dashboard';
}
