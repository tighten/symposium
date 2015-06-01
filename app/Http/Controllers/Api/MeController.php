<?php namespace Symposium\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symposium\ApiResources\Me;

class MeController extends BaseController
{
    public function index()
    {
        $me = new Me(Auth::user());

        return response()->jsonApi([
            'data' => [
                'id' => $me->getId(),
                'type' => $me->getType(),
                'attributes' => $me->attributes()
            ]
        ]);
    }
}
