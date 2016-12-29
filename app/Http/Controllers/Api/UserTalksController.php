<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Talk;
use App\OAuthGuard\Facades\OAuthGuard;
use Illuminate\Support\Facades\App;

class UserTalksController extends BaseController
{
    /**
     * Display all of the given user's talks
     *
     * @return Response
     */
    public function index($userId)
    {
        if ($userId != OAuthGuard::user()->id) {
            App::abort(404);
        }

        $return = OAuthGuard::user()->activeTalks->map(function ($talk) {
            return new Talk($talk);
        })->values();

        return response()->jsonApi([
            'data' => $return
        ]);
    }
}
