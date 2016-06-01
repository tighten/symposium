<?php namespace App\Http\Controllers;

use View;

class HomeController extends BaseController
{
    public function showWelcome()
    {
        return View::make('hello');
    }
}
