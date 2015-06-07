<?php namespace Symposium\Http\Controllers\Api;

use Conference;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use User;

class ConferencesController extends BaseController
{
    public function index()
    {
        $conferences = Conference::all();

        return response()->jsonApi([
            'data' => $conferences
        ]);
    }

    public function show($id)
    {
        $conference = Conference::findOrFail($id);

        return response()->jsonApi([
            'data' => $conference
        ]);
    }
}
