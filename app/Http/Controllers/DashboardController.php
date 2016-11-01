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

        return view('dashboard')
            ->with('bios', auth()->user()->bios)
            ->with('talks', $talks);
    }
}
