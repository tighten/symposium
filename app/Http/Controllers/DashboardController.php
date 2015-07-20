<?php

namespace Symposium\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symposium\Http\Controllers\Controller;
use Symposium\Http\Requests;

class DashboardController extends Controller
{
    public function index()
    {
        $talks = Auth::user()->talks->sortBy(function ($talk) {
            return strtolower($talk->current()->title);
        });

        return view('dashboard')
            ->with('bios', Auth::user()->bios)
            ->with('talks', $talks);
    }
}
