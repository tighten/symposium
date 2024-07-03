<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function show(): View
    {
        return view('home', [
            'speakers' => User::whereFeatured()->limit(6)->get(),
            'conferences' => Conference::whereFeatured()->limit(3)->get(),
        ]);
    }
}
