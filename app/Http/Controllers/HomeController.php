<?php namespace Symposium\Http\Controllers;

use View;

class HomeController extends BaseController
{
    public function showWelcome()
    {
        return View::make('hello');
    }
}
