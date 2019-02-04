<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Talk;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserTalksController extends BaseController
{
    /**
     * Display all of the given user's talks
     *
     * @return Response
     */
    public function index($userId)
    {
        if ($userId != Auth::user()->id) {
            App::abort(404);
        }

        $return = Auth::user()->activeTalks->map(function ($talk) {
            return new Talk($talk);
        })->values();

        return response()->jsonApi([
            'data' => $return
        ]);
    }
}
