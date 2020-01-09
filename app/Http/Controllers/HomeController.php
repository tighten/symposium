<?php

namespace App\Http\Controllers;

use App\User;

class HomeController extends BaseController
{
    public function show()
    {
        $speakers = User::where('featured', 1)->get();

        return view('home', ['speakers' => $speakers]);
    }
}
