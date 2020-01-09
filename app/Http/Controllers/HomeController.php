<?php

namespace App\Http\Controllers;

use App\Conference;
use App\User;

class HomeController extends BaseController
{
    public function show()
    {
        $speakers = User::where('featured', 1)->get();
        $conferences = Conference::where('featured', 1)->get();

        return view('home', [
            'speakers' => $speakers,
            'conferences' => $conferences,
        ]);
    }
}
