<?php namespace SaveMyProposals\Http\Controllers;

use View;

class HomeController extends BaseController
{
    public function showWelcome()
    {
        return View::make('hello');
    }
}
