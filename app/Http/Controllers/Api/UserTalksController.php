<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Talk;
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
        if ($userId != auth()->guard('api')->user()->id) {
            App::abort(404);
        }

        $return = auth()->guard('api')->user()->activeTalks->map(function ($talk) {
            return new Talk($talk);
        })->values();

        return response()->jsonApi([
            'data' => $return,
        ]);
    }
}
