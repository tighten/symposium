<?php namespace Symposium\Http\Controllers\Api;

use Symposium\ApiResources\Me;
use Symposium\oAuthGuard\Facades\oAuthGuard;

class MeController extends BaseController
{
    public function index()
    {
        $me = new Me(oAuthGuard::user());

        return response()->jsonApi([
            'data' => [
                'id' => $me->getId(),
                'type' => $me->getType(),
                'attributes' => $me->attributes()
            ]
        ]);
    }
}
