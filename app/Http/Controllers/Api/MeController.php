<?php

namespace App\Http\Controllers\Api;

use App\ApiResources\Me;
use Illuminate\Support\Facades\Auth;

class MeController extends BaseController
{
    public function index()
    {

        $me = new Me(Auth::guard('api')->user());

        return response()->jsonApi([
            'data' => $me->toArray()
        ]);
    }
}
