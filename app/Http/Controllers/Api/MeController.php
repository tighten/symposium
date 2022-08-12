<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Me;
use App\Http\Controllers\Controller;

class MeController extends Controller
{
    public function index()
    {
        $me = new Me(auth()->guard('api')->user());

        return response()->jsonApi([
            'data' => $me->toArray(),
        ]);
    }
}
