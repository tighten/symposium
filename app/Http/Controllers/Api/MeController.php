<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Me;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class MeController extends Controller
{
    public function index(): JsonResponse
    {
        $me = new Me(auth()->guard('api')->user());

        return response()->jsonApi([
            'data' => $me->toArray(),
        ]);
    }
}
