<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Bio;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class UserBiosController extends Controller
{
    /**
     * Display all of the given user's bios
     */
    public function index($userId): Response
    {
        if ($userId != auth()->guard('api')->user()->id) {
            App::abort(404);
        }

        $return = auth()->guard('api')->user()->bios->map(function ($bio) {
            return new Bio($bio);
        });

        return response()->jsonApi([
            'data' => $return,
        ]);
    }
}
