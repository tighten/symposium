<?php

namespace App\Http\Controllers;

class HomeController extends BaseController
{
    public function showWelcome()
    {
        return view('hello');
    }
}
