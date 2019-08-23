<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $talks = auth()->user()->talks->sortBy(function ($talk) {
            return strtolower($talk->current()->title);
        });

        return view('dashboard', [
            'bios' => auth()->user()->bios,
            'talks' => $talks,
        ]);
    }
}
