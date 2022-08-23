<?php

namespace App\Http\Controllers;

use App\Models\Conference;

class ConferenceIssuesController extends Controller
{
    public function create(Conference $conference)
    {
        return view('conferences.issues.create', [
            'conference' => $conference,
        ]);
    }
}
