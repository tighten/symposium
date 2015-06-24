<?php namespace Symposium\Http\Controllers\Api;

use Symposium\ApiResources\Me;
use Symposium\OAuthGuard\Facades\OAuthGuard;

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
