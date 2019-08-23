<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Me;

class MeController extends BaseController
{
    public function index()
    {
        $me = new Me(auth()->guard('api')->user());

        return response()->jsonApi([
            'data' => $me->toArray(),
        ]);
    }
}
