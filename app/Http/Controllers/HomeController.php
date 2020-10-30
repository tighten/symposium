<?php

namespace App\Http\Controllers;

use App\Conference;
use App\User;

class HomeController extends BaseController
{
    public function show()
    {
        return view('home', [
            'speakers' => User::whereFeatured()->get(),
            'conferences' => Conference::whereFeatured()->get(),
        ]);
    }
}
