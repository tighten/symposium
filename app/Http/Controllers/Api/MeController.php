<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\ApiResources\Me;
use App\Http\Controllers\Controller;

class MeController extends Controller
{
    public function index(): Response
    {
        $me = new Me(auth()->guard('api')->user());

        return response()->jsonApi([
            'data' => $me->toArray(),
        ]);
    }
}
