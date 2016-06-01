<?php namespace App\Http\Controllers\Api;

use App\ApiResources\Me;
use App\OAuthGuard\Facades\OAuthGuard;

class MeController extends BaseController
{
    public function index()
    {
        $me = new Me(OAuthGuard::user());

        return response()->jsonApi([
            'data' => $me->toArray()
        ]);
    }
}
