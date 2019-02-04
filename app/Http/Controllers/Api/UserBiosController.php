<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Bio;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserBiosController extends BaseController
{
    /**
     * Display all of the given user's bios
     *
     * @return Response
     */
    public function index($userId)
    {
        if ($userId != Auth::user()->id) {
            App::abort(404);
        }

        $return = Auth::user()->bios->map(function ($bio) {
            return new Bio($bio);
        });

        return response()->jsonApi([
            'data' => $return,
        ]);
    }
}
