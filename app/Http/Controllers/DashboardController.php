<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests;

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
